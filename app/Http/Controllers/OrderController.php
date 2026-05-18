<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Dish;
use App\Models\Category;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class OrderController extends Controller
{
    public function index()
    {
        $dishes = Category::where('is_active', true)
            ->orderBy('display_order')
            ->with(['dishes' => function ($query) {
                $query->where('is_available', true)->orderBy('name');
            }])
            ->get()
            ->mapWithKeys(fn($category) => [$category->name => $category->dishes]);

        return view('orders.index', compact('dishes'));
    }

    public function cart()
    {
        return view('orders.cart');
    }

    public function checkout()
    {
        return view('orders.checkout');
    }

    public function store(Request $request)
    {
        try {
            Log::info('=== Order Store Request Started ===', [
                'method'         => $request->method(),
                'payment_method' => $request->input('payment_method'),
                'customer_email' => $request->input('customer_email'),
            ]);

            $validated = $request->validate([
                'customer_name'        => 'required|string|max:255',
                'customer_email'       => 'required|email',
                'customer_phone'       => 'required|string',
                'delivery_address'     => 'required|string',
                'payment_method'       => 'required|in:cash,card,online',
                'special_instructions' => 'nullable|string',
                'cart'                 => 'required|json',
            ]);
            $settings = \App\Models\SiteSetting::pluck('value', 'key');
            $restaurantLat = $settings['restaurant_lat'] ?? null;
            $restaurantLng = $settings['restaurant_lng'] ?? null;
            $maxDistance   = $settings['delivery_radius'] ?? 2; // fallback 2km

            if (!$restaurantLat || !$restaurantLng) {
                return response()->json([
                    'success' => false,
                    'message' => 'Restaurant location is not configured.',
                ], 500);
            }

            $cart = json_decode($validated['cart'], true);

            if (!is_array($cart) || empty($cart)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart is empty or invalid',
                ], 400);
            }

            // Calculate totals
            $settings = SiteSetting::pluck('value', 'key');

            $taxRate = $settings['tax_rate'] ?? 8;
            $deliveryFee = $settings['delivery_fee'] ?? 5;
            $maxDistance = $settings['delivery_radius'] ?? 2;

            $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

            $tax = $subtotal * ($taxRate / 100);
            $total = $subtotal + $tax + $deliveryFee;
            $distance = calculateDistance(
                $restaurantLat,
                $restaurantLng,
                $request->latitude,
                $request->longitude
            );
            if ($distance > $maxDistance) {
                return response()->json([
                    'success' => false,
                    'message' => 'Delivery not available in your area. You are too far from the restaurant.',
                    'distance' => round($distance, 2),
                    'max_distance' => $maxDistance,
                ], 400);
            }

            DB::beginTransaction();

            // Create order
            $order = Order::create([
                'customer_name'        => $validated['customer_name'],
                'customer_email'       => $validated['customer_email'],
                'customer_phone'       => $validated['customer_phone'],
                'delivery_address'     => $validated['delivery_address'],
                'payment_method'       => $validated['payment_method'],
                'status'               => 'pending',
                'payment_status'       => 'pending',
                'special_instructions' => $validated['special_instructions'] ?? null,
                'subtotal'             => $subtotal,
                'tax'                  => $tax,
                'delivery_fee'         => $deliveryFee,
                'total'                => $total,
            ]);

            // Create order items
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id'  => $order->id,
                    'dish_id'   => $item['id'] ?? null,
                    'dish_name' => $item['name'],
                    'price'     => $item['price'],
                    'quantity'  => $item['quantity'],
                    'subtotal'  => $item['price'] * $item['quantity'],
                ]);
            }

            DB::commit();

            Log::info('Order created', ['order_id' => $order->id, 'payment_method' => $validated['payment_method']]);

            // ── Cash: redirect straight to success ──────────────────────────
            if ($validated['payment_method'] === 'cash') {
                return response()->json([
                    'success'  => true,
                    'message'  => 'Order placed successfully!',
                    'redirect' => route('orders.success', $order->id),
                ]);
            }

            // ── Card / Online: create Stripe Checkout Session ────────────────
            if (empty(config('stripe.secret'))) {
                Log::error('Stripe secret key not configured');
                return response()->json([
                    'success' => false,
                    'message' => 'Payment gateway is not properly configured.',
                ], 500);
            }

            Stripe::setApiKey(config('stripe.secret'));

            // Build line items
            $lineItems = [];

            foreach ($cart as $item) {
                $lineItems[] = [
                    'price_data' => [
                        'currency'     => 'usd',
                        'product_data' => [
                            'name'        => trim($item['name']),
                            'description' => 'The Lighthouse Cafe',
                        ],
                        'unit_amount' => intval(round($item['price'] * 100)),
                    ],
                    'quantity' => intval($item['quantity']),
                ];
            }

            $lineItems[] = [
                'price_data' => [
                    'currency'     => 'usd',
                    'product_data' => ['name' => 'Tax (' . $taxRate . '%)', 'description' => 'Sales Tax'],
                    'unit_amount'  => intval(round($tax * 100)),
                ],
                'quantity' => 1,
            ];

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Delivery Fee',
                        'description' => 'Standard delivery charge',
                    ],
                    'unit_amount' => intval(round($deliveryFee * 100)),
                ],
                'quantity' => 1,
            ];

            $stripeSession = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items'           => $lineItems,
                'mode'                 => 'payment',
                'customer_email'       => $validated['customer_email'],
                'success_url'          => route('orders.checkout.success', ['order_id' => $order->id], true)
                    . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url'           => route('orders.checkout', [], true),
                'client_reference_id'  => (string) $order->id,
                'metadata'             => [
                    'order_id'         => (string) $order->id,
                    'customer_name'    => $validated['customer_name'],
                    'customer_phone'   => $validated['customer_phone'],
                    'delivery_address' => $validated['delivery_address'],
                ],
                'expires_at' => time() + (30 * 60),
            ]);

            Log::info('Stripe session created', [
                'session_id'   => $stripeSession->id,
                'order_id'     => $order->id,
                'checkout_url' => $stripeSession->url,
            ]);

            // Return the Stripe hosted checkout URL for the frontend to redirect to
            return response()->json([
                'success'      => true,
                'message'      => 'Redirecting to payment...',
                'checkout_url' => $stripeSession->url,
                'order_id'     => $order->id,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . implode(', ', collect($e->errors())->flatten()->all()),
            ], 422);
        } catch (\Stripe\Exception\AuthenticationException $e) {
            Log::error('Stripe Auth Error', ['error' => $e->getMessage()]);
            $this->rollbackIfInTransaction();
            return response()->json([
                'success' => false,
                'message' => 'Payment service authentication failed. Please contact support.',
            ], 401);
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            Log::error('Stripe Invalid Request', ['error' => $e->getMessage()]);
            $this->rollbackIfInTransaction();
            return response()->json([
                'success' => false,
                'message' => 'Payment configuration error: ' . $e->getMessage(),
            ], 400);
        } catch (\Stripe\Exception\RateLimitException $e) {
            Log::error('Stripe Rate Limit', ['error' => $e->getMessage()]);
            $this->rollbackIfInTransaction();
            return response()->json([
                'success' => false,
                'message' => 'Payment service is temporarily busy. Please try again in a moment.',
            ], 429);
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            Log::error('Stripe Connection Error', ['error' => $e->getMessage()]);
            $this->rollbackIfInTransaction();
            return response()->json([
                'success' => false,
                'message' => 'Network error connecting to payment service. Please try again.',
            ], 503);
        } catch (\Exception $e) {
            Log::error('Order/Stripe error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $this->rollbackIfInTransaction();
            return response()->json([
                'success' => false,
                'message' => 'Failed to process order: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function checkoutSuccess($orderId)
    {
        try {
            $order     = Order::findOrFail($orderId);
            $sessionId = request()->query('session_id');

            if ($sessionId) {
                Log::info('Verifying Stripe session', ['order_id' => $orderId, 'session_id' => $sessionId]);

                try {
                    Stripe::setApiKey(config('stripe.secret'));
                    $stripeSession = StripeSession::retrieve($sessionId);

                    Log::info('Stripe session retrieved', [
                        'order_id'       => $orderId,
                        'payment_status' => $stripeSession->payment_status,
                    ]);

                    if ($stripeSession->payment_status !== 'paid') {
                        Log::warning('Stripe payment not successful', [
                            'order_id' => $orderId,
                            'status'   => $stripeSession->payment_status,
                        ]);
                        return redirect()->route('orders.checkout')
                            ->with('error', 'Payment was not successfully processed. Please try again.');
                    }
                } catch (\Exception $e) {
                    Log::error('Error retrieving Stripe session', [
                        'order_id'   => $orderId,
                        'session_id' => $sessionId,
                        'error'      => $e->getMessage(),
                    ]);
                    // Webhook will handle confirmation if session retrieval fails
                }
            }

            $order->update([
                'payment_status' => 'paid',
                'status'         => 'confirmed',
            ]);

            Log::info('Order payment confirmed', ['order_id' => $orderId]);

            return view('orders.success', compact('order'));
        } catch (\Exception $e) {
            Log::error('Checkout success error', ['order_id' => $orderId, 'error' => $e->getMessage()]);
            abort(404);
        }
    }

    public function checkoutCancel($orderId)
    {
        try {
            Order::findOrFail($orderId);
            Log::info('Checkout cancelled', ['order_id' => $orderId]);
        } catch (\Exception $e) {
            Log::error('Checkout cancel error: ' . $e->getMessage());
        }

        return redirect()->route('orders.checkout')
            ->with('error', 'Payment was cancelled. Your order has been saved — you can complete payment from your cart.');
    }

    public function success($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('orders.success', compact('order'));
    }

    public function track($orderNumber)
    {
        $order = Order::with('items')->where('order_number', $orderNumber)->firstOrFail();
        return view('orders.track', compact('order'));
    }

    // ── Private helpers ──────────────────────────────────────────────────────

    private function rollbackIfInTransaction(): void
    {
        if (DB::inTransaction()) {
            DB::rollBack();
        }
    }
}
