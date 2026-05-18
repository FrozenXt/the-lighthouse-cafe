<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of all orders.
     */
    public function index()
    {
        $orders = Order::with('items')
            ->latest()
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display a specific order.
     */
    public function show(Order $order)
    {
        $order->load('items.dish.category');

        if (request()->wantsJson()) {
            return response()->json($order);
        }

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing an order.
     */
    public function edit(Order $order)
    {
        $order->load('items');

        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the order in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'customer_name'        => 'required|string|max:255',
            'customer_email'       => 'nullable|email|max:255',
            'customer_phone'       => 'nullable|string|max:20',
            'delivery_address'     => 'nullable|string|max:500',
            'special_instructions' => 'nullable|string|max:1000',
            'status'               => 'required|in:pending,confirmed,preparing,ready,delivered,cancelled',
            'payment_status'       => 'required|in:pending,paid,failed,refunded',
            'payment_method'       => 'required|in:cash,card,online',
        ]);

        $order->update($validated);

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', "Order #{$order->order_number} updated successfully.");
    }

    /**
     * Quick status update (used from index dropdown if needed).
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,ready,delivered,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', "Order #{$order->order_number} status updated.");
    }

    /**
     * Delete an order.
     */
    public function destroy(Order $order)
    {
        $orderNumber = $order->order_number;

        $order->items()->delete(); // delete related items first
        $order->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with('success', "Order #{$orderNumber} has been deleted.");
    }
}
