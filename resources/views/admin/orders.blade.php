<!-- resources/views/admin/orders.blade.php -->
@extends('admin.layouts.app')

@section('title', 'Manage Orders')

@section('content')
    <div x-data="{ filterStatus: 'all' }">
        <!-- Filters and Actions -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h2 class="text-2xl font-serif font-bold text-slate-800 mb-2">All Orders</h2>
                    <p class="text-slate-600">Manage and track customer orders</p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <button @click="filterStatus = 'all'"
                        :class="filterStatus === 'all' ? 'bg-slate-800 text-white' :
                            'bg-white text-slate-700 border border-slate-300'"
                        class="px-4 py-2 rounded-lg font-semibold transition">
                        All Orders
                    </button>
                    <button @click="filterStatus = 'pending'"
                        :class="filterStatus === 'pending' ? 'bg-yellow-500 text-white' :
                            'bg-white text-slate-700 border border-slate-300'"
                        class="px-4 py-2 rounded-lg font-semibold transition">
                        Pending
                    </button>
                    <button @click="filterStatus = 'confirmed'"
                        :class="filterStatus === 'confirmed' ? 'bg-blue-500 text-white' :
                            'bg-white text-slate-700 border border-slate-300'"
                        class="px-4 py-2 rounded-lg font-semibold transition">
                        Confirmed
                    </button>
                    <button @click="filterStatus = 'preparing'"
                        :class="filterStatus === 'preparing' ? 'bg-purple-500 text-white' :
                            'bg-white text-slate-700 border border-slate-300'"
                        class="px-4 py-2 rounded-lg font-semibold transition">
                        Preparing
                    </button>
                </div>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b-2 border-slate-200">
                        <tr>
                            <th class="text-left py-4 px-6 font-bold text-slate-700">Order #</th>
                            <th class="text-left py-4 px-6 font-bold text-slate-700">Customer</th>
                            <th class="text-left py-4 px-6 font-bold text-slate-700">Items</th>
                            <th class="text-left py-4 px-6 font-bold text-slate-700">Total</th>
                            <th class="text-left py-4 px-6 font-bold text-slate-700">Payment</th>
                            <th class="text-left py-4 px-6 font-bold text-slate-700">Status</th>
                            <th class="text-left py-4 px-6 font-bold text-slate-700">Date</th>
                            <th class="text-left py-4 px-6 font-bold text-slate-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($orders as $order)
                            <tr class="hover:bg-slate-50 transition"
                                x-show="filterStatus === 'all' || filterStatus === '{{ $order->status }}'">
                                <td class="py-4 px-6">
                                    <span
                                        class="font-mono text-sm font-bold text-slate-800 bg-slate-100 px-3 py-1 rounded">{{ $order->order_number }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <div>
                                        <p class="font-bold text-slate-800">{{ $order->customer_name }}</p>
                                        <p class="text-sm text-slate-600">{{ $order->customer_phone }}</p>
                                        <p class="text-xs text-slate-500">{{ $order->customer_email }}</p>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex flex-col">
                                        <span class="font-semibold text-slate-700">{{ $order->items->count() }}
                                            items</span>
                                        <button onclick="toggleOrderDetails('order-{{ $order->id }}')"
                                            class="text-xs text-amber-600 hover:text-amber-700 mt-1 text-left">View
                                            details</button>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <span
                                        class="font-bold text-xl text-amber-600">${{ number_format($order->total, 2) }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex flex-col gap-1">
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-bold {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                        <span class="text-xs text-slate-500">{{ ucfirst($order->payment_method) }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                                        @csrf
                                        <select name="status" onchange="this.form.submit()"
                                            class="px-3 py-2 rounded-lg text-sm font-semibold border-2 cursor-pointer transition {{ $order->status_color }}">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>⏳
                                                Pending</option>
                                            <option value="confirmed"
                                                {{ $order->status == 'confirmed' ? 'selected' : '' }}>✓ Confirmed</option>
                                            <option value="preparing"
                                                {{ $order->status == 'preparing' ? 'selected' : '' }}>👨‍🍳 Preparing
                                            </option>
                                            <option value="ready" {{ $order->status == 'ready' ? 'selected' : '' }}>✓
                                                Ready</option>
                                            <option value="delivered"
                                                {{ $order->status == 'delivered' ? 'selected' : '' }}>🚚 Delivered</option>
                                            <option value="cancelled"
                                                {{ $order->status == 'cancelled' ? 'selected' : '' }}>✗ Cancelled</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="text-sm">
                                        <p class="text-slate-700 font-medium">{{ $order->created_at->format('M d, Y') }}
                                        </p>
                                        <p class="text-slate-500">{{ $order->created_at->format('h:i A') }}</p>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <button onclick="viewOrderModal({{ $order->id }})"
                                        class="text-amber-600 hover:text-amber-700 font-semibold text-sm">
                                        View Full Details
                                    </button>
                                </td>
                            </tr>
                            <!-- Order Details Row (Hidden by default) -->
                            <tr id="order-{{ $order->id }}" class="hidden bg-slate-50">
                                <td colspan="8" class="py-4 px-6">
                                    <div class="bg-white rounded-lg p-4 border border-slate-200">
                                        <h4 class="font-bold text-slate-800 mb-3">Order Items:</h4>
                                        <div class="space-y-2">
                                            @foreach ($order->items as $item)
                                                <div
                                                    class="flex justify-between items-center py-2 border-b border-slate-200">
                                                    <div class="flex-1">
                                                        <span class="font-semibold text-slate-800">{{ $item->quantity }}x
                                                            {{ $item->dish_name }}</span>
                                                        <span class="text-sm text-slate-600">@
                                                            ${{ number_format($item->price, 2) }}</span>
                                                    </div>
                                                    <span
                                                        class="font-bold text-amber-600">${{ number_format($item->subtotal, 2) }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="mt-4 pt-4 border-t-2 border-slate-300">
                                            <p class="text-sm"><strong>Delivery Address:</strong>
                                                {{ $order->delivery_address }}</p>
                                            @if ($order->special_instructions)
                                                <p class="text-sm mt-2"><strong>Special Instructions:</strong>
                                                    {{ $order->special_instructions }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-12">
                                    <div class="text-slate-400">
                                        <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <p class="text-lg font-semibold">No orders found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-6 border-t border-slate-200 bg-slate-50">
                {{ $orders->links() }}
            </div>
        </div>
    </div>

    <script>
        function toggleOrderDetails(id) {
            const element = document.getElementById(id);
            if (element.classList.contains('hidden')) {
                element.classList.remove('hidden');
            } else {
                element.classList.add('hidden');
            }
        }
    </script>
@endsection
