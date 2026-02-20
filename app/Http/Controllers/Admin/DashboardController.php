<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Dish;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\OrderItem;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'today_revenue' => Order::whereDate('created_at', today())->sum('total'),
            'total_revenue' => Order::sum('total')
        ];

        $recentOrders = Order::with('items')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $popularDishes = Dish::withCount(['orderItems' => function ($query) {
            $query->whereHas('order', function ($q) {
                $q->where('created_at', '>=', Carbon::now()->subDays(30));
            });
        }])
            ->orderBy('order_items_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'popularDishes'));
    }

    public function orders()
    {
        $orders = Order::with('items')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.orders', compact('orders'));
    }

    public function showOrder(Order $order)
    {
        $order->load('items');

        // Calculate subtotal
        $subtotal = $order->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return response()->json([
            'id' => $order->id,
            'order_number' => $order->order_number,
            'customer_name' => $order->customer_name,
            'customer_email' => $order->customer_email,
            'customer_phone' => $order->customer_phone,
            'delivery_address' => $order->delivery_address,
            'special_instructions' => $order->special_instructions,
            'status' => $order->status,
            'payment_status' => $order->payment_status,
            'payment_method' => $order->payment_method,
            'total' => $order->total,
            'subtotal' => $subtotal,
            'delivery_fee' => $order->delivery_fee ?? 5.00,
            'created_at' => $order->created_at,
            'items' => $order->items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'dish_name' => $item->dish_name,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->price * $item->quantity
                ];
            })->toArray()
        ]);
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,ready,delivered,cancelled'
        ]);

        $order->update(['status' => $validated['status']]);

        if ($validated['status'] === 'confirmed') {
            $order->update(['confirmed_at' => now()]);
        } elseif ($validated['status'] === 'delivered') {
            $order->update(['delivered_at' => now()]);
        }

        return back()->with('success', 'Order status updated successfully!');
    }

    public function deleteOrder(Order $order)
    {
        // Delete associated order items first
        $order->items()->delete();

        // Delete the order
        $order->delete();

        return back()->with('success', 'Order deleted successfully!');
    }
}
