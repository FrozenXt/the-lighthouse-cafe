@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Welcome Section -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-4xl font-serif font-bold text-slate-800">Dashboard Overview</h1>
                <p class="text-slate-600 mt-2">Welcome back, {{ auth('admin')->user()->name }}! Here's your restaurant
                    performance.</p>
            </div>
            <div class="flex gap-3">
                <button onclick="window.location.reload()"
                    class="bg-white hover:bg-slate-50 text-slate-700 px-4 py-2 rounded-lg border border-slate-300 transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Refresh
                </button>
                <a href="{{ route('admin.orders') }}"
                    class="bg-amber-500 hover:bg-amber-600 text-slate-900 px-6 py-2 rounded-lg font-semibold transition">
                    View All Orders
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Orders -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-xl transition">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-slate-600 text-sm font-semibold mb-1">Total Orders</p>
                    <h3 class="text-4xl font-bold text-slate-800">{{ $stats['total_orders'] }}</h3>
                    <p class="text-sm text-slate-500 mt-2">All time orders</p>
                </div>
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500 hover:shadow-xl transition">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-slate-600 text-sm font-semibold mb-1">Pending Orders</p>
                    <h3 class="text-4xl font-bold text-slate-800">{{ $stats['pending_orders'] }}</h3>
                    <p class="text-sm text-yellow-600 mt-2 font-semibold">
                        @if ($stats['pending_orders'] > 0)
                            Action required!
                        @else
                            All caught up
                        @endif
                    </p>
                </div>
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Today's Orders -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-slate-600 text-sm font-semibold mb-1">Today's Orders</p>
                    <h3 class="text-4xl font-bold text-slate-800">{{ $stats['today_orders'] }}</h3>
                    <p class="text-sm text-slate-500 mt-2">{{ now()->format('M d, Y') }}</p>
                </div>
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Today's Revenue -->
        <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500 hover:shadow-xl transition">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-slate-600 text-sm font-semibold mb-1">Today's Revenue</p>
                    <h3 class="text-4xl font-bold text-slate-800">${{ number_format($stats['today_revenue'], 2) }}</h3>
                    <p class="text-sm text-slate-500 mt-2">Total: ${{ number_format($stats['total_revenue'], 2) }}</p>
                </div>
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Orders -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-6 bg-gradient-to-r from-slate-800 to-slate-900 text-white flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-serif font-bold">Recent Orders</h2>
                        <p class="text-slate-300 text-sm mt-1">Latest customer orders</p>
                    </div>
                    <a href="{{ route('admin.orders') }}"
                        class="bg-amber-500 hover:bg-amber-600 text-slate-900 px-4 py-2 rounded-lg font-semibold transition text-sm">
                        View All
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b-2 border-slate-200">
                            <tr>
                                <th class="text-left py-4 px-6 font-bold text-slate-700 text-sm">Order #</th>
                                <th class="text-left py-4 px-6 font-bold text-slate-700 text-sm">Customer</th>
                                <th class="text-left py-4 px-6 font-bold text-slate-700 text-sm">Items</th>
                                <th class="text-left py-4 px-6 font-bold text-slate-700 text-sm">Total</th>
                                <th class="text-left py-4 px-6 font-bold text-slate-700 text-sm">Status</th>
                                <th class="text-left py-4 px-6 font-bold text-slate-700 text-sm">Time</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($recentOrders as $order)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="py-4 px-6">
                                        <span
                                            class="font-mono text-sm font-bold text-slate-800 bg-slate-100 px-2 py-1 rounded">{{ $order->order_number }}</span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div>
                                            <p class="font-semibold text-slate-800">{{ $order->customer_name }}</p>
                                            <p class="text-xs text-slate-500">{{ $order->customer_phone }}</p>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="text-slate-700 font-medium">{{ $order->items->count() }} items</span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span
                                            class="font-bold text-lg text-amber-600">${{ number_format($order->total, 2) }}</span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $order->status_color }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="text-sm">
                                            <p class="text-slate-700 font-medium">{{ $order->created_at->format('M d') }}
                                            </p>
                                            <p class="text-slate-500">{{ $order->created_at->format('h:i A') }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-12">
                                        <div class="text-slate-400">
                                            <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                            </svg>
                                            <p class="text-lg font-semibold">No orders yet</p>
                                            <p class="text-sm mt-1">Orders will appear here when customers place them</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Popular Dishes -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-6 bg-gradient-to-r from-amber-500 to-amber-600 text-slate-900">
                    <h2 class="text-xl font-serif font-bold">Popular Dishes</h2>
                    <p class="text-slate-800 text-sm mt-1">Last 30 days</p>
                </div>

                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($popularDishes as $index => $dish)
                            <div class="flex items-center gap-4 p-3 bg-slate-50 rounded-lg hover:bg-slate-100 transition">
                                <div
                                    class="flex-shrink-0 w-10 h-10 bg-amber-500 text-white rounded-full flex items-center justify-center font-bold text-lg">
                                    {{ $index + 1 }}
                                </div>
                                <img src="{{ $dish->image_url }}" alt="{{ $dish->name }}"
                                    class="w-14 h-14 rounded-lg object-cover">
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold text-slate-800 truncate">{{ $dish->name }}</h4>
                                    <p class="text-sm text-slate-600">${{ number_format($dish->price, 2) }}</p>
                                </div>
                                <div class="text-right">
                                    <div class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold">
                                        {{ $dish->order_items_count }}
                                    </div>
                                    <p class="text-xs text-slate-500 mt-1">orders</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-slate-400">
                                <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                <p class="text-sm font-semibold">No data available</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-serif font-bold text-slate-800 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.orders') }}"
                        class="flex items-center gap-3 p-3 bg-slate-50 hover:bg-slate-100 rounded-lg transition">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <span class="font-semibold text-slate-700">Manage Orders</span>
                    </a>

                    <a href="{{ route('menu') }}" target="_blank"
                        class="flex items-center gap-3 p-3 bg-slate-50 hover:bg-slate-100 rounded-lg transition">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <span class="font-semibold text-slate-700">View Menu</span>
                    </a>

                    <a href="{{ route('home') }}" target="_blank"
                        class="flex items-center gap-3 p-3 bg-slate-50 hover:bg-slate-100 rounded-lg transition">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                            </svg>
                        </div>
                        <span class="font-semibold text-slate-700">Visit Website</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
