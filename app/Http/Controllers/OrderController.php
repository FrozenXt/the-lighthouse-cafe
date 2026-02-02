<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Dish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $dishes = Dish::where('is_available', true)
            ->orderBy('category')
            ->get()
            ->groupBy('category');

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
            $cart = json_decode($validated['cart'], true);

            // Calculate totals
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
                'special_instructions' => $validated['special_instructions'],
                'subtotal' => $subtotal,
                'tax' => $tax,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
                'status' => 'pending',
                'payment_status' => 'pending'
            ]);

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

            return redirect()->route('orders.success', $order->id)
                ->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to place order. Please try again.');
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
