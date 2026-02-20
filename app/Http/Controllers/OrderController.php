<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Dish;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class OrderController extends Controller
{
    public function index()
    {
        // Get active categories with their available dishes
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
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string',
            'delivery_address' => 'required|string',
            'payment_method' => 'required|in:cash,card,online',
            'special_instructions' => 'nullable|string',
            'cart' => 'required|json'
        ]);

        DB::beginTransaction();
        try {
            Log::info('Order creation started', ['payment_method' => $validated['payment_method']]);

            $cart = json_decode($validated['cart'], true);

            if (!is_array($cart) || empty($cart)) {
                throw new \Exception('Cart is empty or invalid');
            }

            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            $tax = $subtotal * 0.08; // 8% tax
            $deliveryFee = 5.00;
            $total = $subtotal + $tax + $deliveryFee;

            // Create order
            $order = Order::create([
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'delivery_address' => $validated['delivery_address'],
                'payment_method' => $validated['payment_method'],
                'status' => 'pending',
                'payment_status' => in_array($validated['payment_method'], ['online', 'card']) ? 'pending' : 'pending',
                'special_instructions' => $validated['special_instructions'] ?? null,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
            ]);

            Log::info('Order created', ['order_id' => $order->id, 'total' => $total]);

            // Create order items
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'dish_id' => $item['id'],
                    'dish_name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity']
                ]);
            }

            DB::commit();

            // If payment method is cash, redirect to success
            if ($validated['payment_method'] === 'cash') {
                Log::info('Cash payment, skipping Stripe', ['order_id' => $order->id]);
                return response()->json([
                    'success' => true,
                    'message' => 'Order placed successfully!',
                    'redirect' => route('orders.success', $order->id)
                ]);
            }

            // For card/online payment, create Stripe Checkout session
            if (empty(config('stripe.secret')) || config('stripe.secret') === 'your_stripe_secret_key') {
                throw new \Exception('Stripe is not properly configured. Please set STRIPE_SECRET in your .env file.');
            }

            try {
                Stripe::setApiKey(config('stripe.secret'));

                // Build line items for Stripe
                $lineItems = [];

                // Add each cart item
                foreach ($cart as $item) {
                    $lineItems[] = [
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => $item['name'],
                                'description' => 'The Lighthouse Cafe'
                            ],
                            'unit_amount' => intval($item['price'] * 100),
                        ],
                        'quantity' => intval($item['quantity']),
                    ];
                }

                // Add tax line item
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Tax (8%)',
                        ],
                        'unit_amount' => intval($tax * 100),
                    ],
                    'quantity' => 1,
                ];

                // Add delivery fee
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Delivery Fee',
                        ],
                        'unit_amount' => intval($deliveryFee * 100),
                    ],
                    'quantity' => 1,
                ];

                Log::info('Creating Stripe session', ['order_id' => $order->id, 'items_count' => count($lineItems), 'total_cents' => intval($total * 100)]);

                $session = Session::create([
                    'customer_email' => $validated['customer_email'],
                    'payment_method_types' => ['card'],
                    'line_items' => $lineItems,
                    'mode' => 'payment',
                    'success_url' => route('orders.checkout.success', ['order_id' => $order->id], true),
                    'cancel_url' => route('orders.checkout.cancel', ['order_id' => $order->id], true),
                    'metadata' => [
                        'order_id' => $order->id,
                        'customer_name' => $validated['customer_name'],
                        'customer_phone' => $validated['customer_phone'],
                        'delivery_address' => $validated['delivery_address'],
                    ]
                ]);

                Log::info('Stripe session created successfully', [
                    'session_id' => $session->id,
                    'order_id' => $order->id,
                    'checkout_url' => $session->url
                ]);

                return response()->json([
                    'success' => true,
                    'checkout_url' => $session->url,
                    'order_id' => $order->id,
                ]);
            } catch (\Exception $stripeError) {
                Log::error('Stripe API error', [
                    'error' => $stripeError->getMessage(),
                    'code' => $stripeError->getCode(),
                    'order_id' => $order->id
                ]);
                throw new \Exception('Stripe payment gateway error: ' . $stripeError->getMessage());
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order creation error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function checkoutSuccess($orderId)
    {
        try {
            $order = Order::findOrFail($orderId);
            $order->update([
                'payment_status' => 'paid',
                'status' => 'confirmed'
            ]);
            Log::info('Order payment confirmed', ['order_id' => $orderId]);
            return view('orders.success', compact('order'));
        } catch (\Exception $e) {
            Log::error('Checkout success error: ' . $e->getMessage());
            abort(404);
        }
    }

    public function checkoutCancel($orderId)
    {
        try {
            $order = Order::findOrFail($orderId);
            Log::info('Checkout cancelled by user', ['order_id' => $orderId]);
            return redirect()->route('orders.checkout')->with('error', 'Payment was cancelled. Your order has been saved. You can continue from your cart.');
        } catch (\Exception $e) {
            Log::error('Checkout cancel error: ' . $e->getMessage());
            return redirect()->route('orders.index');
        }
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
}
