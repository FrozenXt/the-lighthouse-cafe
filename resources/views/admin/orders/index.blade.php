@extends('admin.layouts.app')

@section('title', 'Manage Orders')

@section('content')
    <div x-data="{ filterStatus: 'all' }">

        {{-- Header & Filters --}}
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h2 class="text-2xl font-serif font-bold text-slate-800 mb-1">All Orders</h2>
                    <p class="text-slate-500 text-sm">Manage and track customer orders</p>
                </div>

                <div class="flex flex-wrap gap-2">
                    @foreach ([
                        'all'       => ['label' => 'All Orders',  'active' => 'bg-slate-800 text-white'],
                        'pending'   => ['label' => '⏳ Pending',   'active' => 'bg-yellow-500 text-white'],
                        'confirmed' => ['label' => '✓ Confirmed', 'active' => 'bg-blue-500 text-white'],
                        'preparing' => ['label' => '👨‍🍳 Preparing', 'active' => 'bg-purple-500 text-white'],
                        'ready'     => ['label' => '✓ Ready',     'active' => 'bg-green-500 text-white'],
                        'delivered' => ['label' => '🚚 Delivered', 'active' => 'bg-teal-500 text-white'],
                        'cancelled' => ['label' => '✗ Cancelled', 'active' => 'bg-red-500 text-white'],
                    ] as $status => $config)
                        <button
                            @click="filterStatus = '{{ $status }}'"
                            :class="filterStatus === '{{ $status }}'
                                ? '{{ $config['active'] }}'
                                : 'bg-white text-slate-700 border border-slate-300 hover:bg-slate-50'"
                            class="px-4 py-2 rounded-lg font-semibold text-sm transition">
                            {{ $config['label'] }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Orders Table --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b-2 border-slate-200">
                        <tr>
                            <th class="text-left py-4 px-6 font-bold text-slate-700 text-sm">Order #</th>
                            <th class="text-left py-4 px-6 font-bold text-slate-700 text-sm">Customer</th>
                            <th class="text-left py-4 px-6 font-bold text-slate-700 text-sm">Items</th>
                            <th class="text-left py-4 px-6 font-bold text-slate-700 text-sm">Total</th>
                            <th class="text-left py-4 px-6 font-bold text-slate-700 text-sm">Payment</th>
                            <th class="text-left py-4 px-6 font-bold text-slate-700 text-sm">Status</th>
                            <th class="text-left py-4 px-6 font-bold text-slate-700 text-sm">Date</th>
                            <th class="text-left py-4 px-6 font-bold text-slate-700 text-sm">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($orders as $order)
                            <tr class="hover:bg-slate-50 transition"
                                x-show="filterStatus === 'all' || filterStatus === '{{ $order->status }}'">

                                {{-- Order Number --}}
                                <td class="py-4 px-6">
                                    <span class="font-mono text-sm font-bold text-slate-800 bg-slate-100 px-3 py-1 rounded">
                                        {{ $order->order_number }}
                                    </span>
                                </td>

                                {{-- Customer --}}
                                <td class="py-4 px-6">
                                    <p class="font-bold text-slate-800">{{ $order->customer_name }}</p>
                                    <p class="text-sm text-slate-500">{{ $order->customer_phone }}</p>
                                    <p class="text-xs text-slate-400">{{ $order->customer_email }}</p>
                                </td>

                                {{-- Items count --}}
                                <td class="py-4 px-6">
                                    <span class="font-semibold text-slate-700">{{ $order->items->count() }} items</span>
                                </td>

                                {{-- Total --}}
                                <td class="py-4 px-6">
                                    <span class="font-bold text-xl text-amber-600">${{ number_format($order->total, 2) }}</span>
                                </td>

                                {{-- Payment --}}
                                <td class="py-4 px-6">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold
                                        {{ $order->payment_status === 'paid'
                                            ? 'bg-green-100 text-green-800'
                                            : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                    <p class="text-xs text-slate-500 mt-1">{{ ucfirst($order->payment_method) }}</p>
                                </td>

                                {{-- Status badge --}}
                                <td class="py-4 px-6">
                                    @php
                                        $badges = [
                                            'pending'   => 'bg-yellow-100 text-yellow-800',
                                            'confirmed' => 'bg-blue-100 text-blue-800',
                                            'preparing' => 'bg-purple-100 text-purple-800',
                                            'ready'     => 'bg-green-100 text-green-800',
                                            'delivered' => 'bg-teal-100 text-teal-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $badges[$order->status] ?? 'bg-slate-100 text-slate-700' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>

                                {{-- Date --}}
                                <td class="py-4 px-6 text-sm">
                                    <p class="text-slate-700 font-medium">{{ $order->created_at->format('M d, Y') }}</p>
                                    <p class="text-slate-400">{{ $order->created_at->format('h:i A') }}</p>
                                </td>

                                {{-- Actions --}}
                                <td class="py-4 px-6">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.orders.show', $order) }}"
                                            class="text-amber-600 hover:text-amber-700 font-semibold text-sm bg-amber-50 hover:bg-amber-100 px-3 py-1 rounded transition">
                                            View
                                        </a>
                                        <a href="{{ route('admin.orders.edit', $order) }}"
                                            class="text-blue-600 hover:text-blue-700 font-semibold text-sm bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Delete this order? This cannot be undone.')"
                                                class="text-red-600 hover:text-red-700 font-semibold text-sm bg-red-50 hover:bg-red-100 px-3 py-1 rounded transition">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-16">
                                    <svg class="w-16 h-16 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <p class="text-slate-400 text-lg font-semibold">No orders found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="p-6 border-t border-slate-200 bg-slate-50">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
