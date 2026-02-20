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
                                    <div class="flex gap-2">
                                        <button onclick="viewOrderModal({{ $order->id }})"
                                            class="text-amber-600 hover:text-amber-700 font-semibold text-sm bg-amber-50 hover:bg-amber-100 px-3 py-1 rounded transition">
                                            View
                                        </button>
                                        <form action="{{ route('admin.orders.delete', $order) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this order? This action cannot be undone.')"
                                                class="text-red-600 hover:text-red-700 font-semibold text-sm bg-red-50 hover:bg-red-100 px-3 py-1 rounded transition">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
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

    <!-- Order Details Modal -->
    <div id="orderModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b border-slate-200 p-6 flex justify-between items-center">
                <h2 class="text-2xl font-serif font-bold text-slate-800">Order Details</h2>
                <button onclick="closeOrderModal()" class="text-slate-400 hover:text-slate-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-6" id="modalBody">
                <!-- Order details will be loaded here -->
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

        function viewOrderModal(orderId) {
            const modal = document.getElementById('orderModal');
            const modalBody = document.getElementById('modalBody');

            // Fetch order details
            fetch(`/admin/orders/${orderId}`, {
                    headers: {
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Populate modal with order data
                    let itemsHTML = '';
                    data.items.forEach(item => {
                        itemsHTML += `
                        <div class="flex justify-between items-start py-3 border-b border-slate-200">
                            <div>
                                <p class="font-semibold text-slate-800">${item.quantity}x ${item.dish_name}</p>
                                <p class="text-sm text-slate-600">@ $${parseFloat(item.price).toFixed(2)}</p>
                            </div>
                            <span class="font-bold text-amber-600">$${parseFloat(item.subtotal).toFixed(2)}</span>
                        </div>
                    `;
                    });

                    const statusColor = {
                        'pending': 'bg-yellow-100 text-yellow-800',
                        'confirmed': 'bg-blue-100 text-blue-800',
                        'preparing': 'bg-purple-100 text-purple-800',
                        'ready': 'bg-green-100 text-green-800',
                        'delivered': 'bg-green-100 text-green-800',
                        'cancelled': 'bg-red-100 text-red-800'
                    };

                    const paymentStatusColor = data.payment_status === 'paid' ? 'bg-green-100 text-green-800' :
                        'bg-yellow-100 text-yellow-800';

                    modalBody.innerHTML = `
                    <div class="bg-slate-50 p-6 rounded-lg mb-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-slate-600 mb-1">Order Number</p>
                                <p class="font-bold text-slate-800">${data.order_number}</p>
                            </div>
                            <div>
                                <p class="text-sm text-slate-600 mb-1">Date</p>
                                <p class="font-bold text-slate-800">${new Date(data.created_at).toLocaleDateString()}</p>
                            </div>
                            <div>
                                <p class="text-sm text-slate-600 mb-1">Status</p>
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold ${statusColor[data.status] || 'bg-gray-100'}">${data.status.charAt(0).toUpperCase() + data.status.slice(1)}</span>
                            </div>
                            <div>
                                <p class="text-sm text-slate-600 mb-1">Payment Status</p>
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-bold ${paymentStatusColor}">${data.payment_status.charAt(0).toUpperCase() + data.payment_status.slice(1)}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="font-bold text-slate-800 mb-4">Customer Information</h4>
                        <div class="space-y-2">
                            <p><strong class="text-slate-700">Name:</strong> <span class="text-slate-600">${data.customer_name}</span></p>
                            <p><strong class="text-slate-700">Email:</strong> <span class="text-slate-600">${data.customer_email}</span></p>
                            <p><strong class="text-slate-700">Phone:</strong> <span class="text-slate-600">${data.customer_phone}</span></p>
                            <p><strong class="text-slate-700">Delivery Address:</strong> <span class="text-slate-600">${data.delivery_address}</span></p>
                            ${data.special_instructions ? `<p><strong class="text-slate-700">Special Instructions:</strong> <span class="text-slate-600">${data.special_instructions}</span></p>` : ''}
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="font-bold text-slate-800 mb-4">Order Items</h4>
                        <div>
                            ${itemsHTML}
                        </div>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-lg">
                        <div class="flex justify-between mb-2">
                            <span class="text-slate-700">Subtotal:</span>
                            <span class="font-semibold">$${parseFloat(data.subtotal || '0').toFixed(2)}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-slate-700">Tax (8%):</span>
                            <span class="font-semibold">$${(parseFloat(data.subtotal || '0') * 0.08).toFixed(2)}</span>
                        </div>
                        <div class="flex justify-between mb-3 pb-3 border-b border-slate-300">
                            <span class="text-slate-700">Delivery Fee:</span>
                            <span class="font-semibold">$${parseFloat(data.delivery_fee || '5.00').toFixed(2)}</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold">
                            <span class="text-slate-800">Total:</span>
                            <span class="text-amber-600">$${parseFloat(data.total).toFixed(2)}</span>
                        </div>
                    </div>
                `;

                    modal.classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to load order details');
                });
        }

        function closeOrderModal() {
            const modal = document.getElementById('orderModal');
            modal.classList.add('hidden');
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('orderModal');
            if (event.target === modal) {
                closeOrderModal();
            }
        });
    </script>
@endsection
