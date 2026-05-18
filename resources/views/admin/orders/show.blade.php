@extends('admin.layouts.app')

@section('title', 'Order #' . $order->order_number)

@section('content')
    @php
        $statusBadge = [
            'pending'   => 'bg-yellow-100 text-yellow-800',
            'confirmed' => 'bg-blue-100 text-blue-800',
            'preparing' => 'bg-purple-100 text-purple-800',
            'ready'     => 'bg-green-100 text-green-800',
            'delivered' => 'bg-teal-100 text-teal-800',
            'cancelled' => 'bg-red-100 text-red-800',
        ];
    @endphp

    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.orders.index') }}"
                class="text-slate-500 hover:text-slate-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="text-2xl font-serif font-bold text-slate-800">Order Details</h2>
                <p class="text-slate-500 text-sm font-mono">{{ $order->order_number }}</p>
            </div>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.orders.edit', $order) }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg transition text-sm">
                Edit Order
            </a>
            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                    onclick="return confirm('Delete this order? This cannot be undone.')"
                    class="bg-red-50 hover:bg-red-100 text-red-600 font-semibold px-5 py-2 rounded-lg transition text-sm border border-red-200">
                    Delete
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left Column: Order Items + Summary --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Order Items --}}
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-6 border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800">
                        Order Items
                        <span class="ml-2 text-sm font-normal text-slate-400">({{ $order->items->count() }} items)</span>
                    </h3>
                </div>
                <div class="divide-y divide-slate-100">
                    @foreach ($order->items as $item)
                        <div class="flex items-center gap-4 px-6 py-4">

                            {{-- Dish Image --}}
                            <div class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden bg-slate-100 border border-slate-200">
                                @if ($item->dish && $item->dish->image)
                                    <img
                                        src="{{ asset('storage/' . $item->dish->image) }}"
                                        alt="{{ $item->dish_name }}"
                                        class="w-full h-full object-cover"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                    >
                                    {{-- Hidden fallback shown if image fails to load --}}
                                    <div style="display:none" class="w-full h-full flex items-center justify-center">
                                        <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @else
                                    {{-- No image stored — show placeholder --}}
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            {{-- Dish Info --}}
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-slate-800">{{ $item->dish_name }}</p>
                                <p class="text-sm text-slate-500 mt-0.5">
                                    Qty: {{ $item->quantity }}
                                    &times;
                                    {{ site_setting('currency_symbol', '$') }}{{ number_format($item->price, 2) }}
                                </p>
                                @if ($item->dish && $item->dish->category)
                                    <span class="inline-block mt-1 text-xs bg-slate-100 text-slate-500 px-2 py-0.5 rounded-full">
                                       {{ $item->dish->category ?? 'Uncategorized' }}
                                    </span>
                                @endif
                            </div>

                            {{-- Subtotal --}}
                            <span class="font-bold text-amber-600 text-lg flex-shrink-0">
                                {{ site_setting('currency_symbol', '$') }}{{ number_format($item->subtotal, 2) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Price Breakdown --}}
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Price Breakdown</h3>
                <div class="space-y-3">
                    <div class="flex justify-between text-slate-600">
                        <span>Subtotal</span>
                        <span>{{ site_setting('currency_symbol', '$') }}{{ number_format($order->subtotal ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Tax ({{ site_setting('tax_rate', 8) }}%)</span>
                        <span>{{ site_setting('currency_symbol', '$') }}{{ number_format($order->tax ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Delivery Fee</span>
                        <span>{{ site_setting('currency_symbol', '$') }}{{ number_format($order->delivery_fee ?? 0, 2) }}</span>
                    </div>
                    <div class="border-t-2 border-slate-200 pt-3 flex justify-between font-bold text-lg">
                        <span class="text-slate-800">Total</span>
                        <span class="text-amber-600">{{ site_setting('currency_symbol', '$') }}{{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            {{-- Special Instructions --}}
            @if ($order->special_instructions)
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-6">
                    <h3 class="text-lg font-bold text-amber-800 mb-2">Special Instructions</h3>
                    <p class="text-amber-700">{{ $order->special_instructions }}</p>
                </div>
            @endif
        </div>

        {{-- Right Column: Meta Info --}}
        <div class="space-y-6">

            {{-- Status & Payment --}}
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Order Status</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Status</p>
                        <span class="inline-block px-4 py-1.5 rounded-full text-sm font-bold {{ $statusBadge[$order->status] ?? 'bg-slate-100 text-slate-700' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Payment Status</p>
                        <span class="inline-block px-4 py-1.5 rounded-full text-sm font-bold
                            {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Payment Method</p>
                        <p class="text-slate-700 font-semibold">{{ ucfirst($order->payment_method) }}</p>
                    </div>
                </div>
            </div>

            {{-- Customer Info --}}
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Customer</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Name</p>
                        <p class="text-slate-800 font-semibold">{{ $order->customer_name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Email</p>
                        <p class="text-slate-700">{{ $order->customer_email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Phone</p>
                        <p class="text-slate-700">{{ $order->customer_phone }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Delivery Address</p>
                        <p class="text-slate-700">{{ $order->delivery_address }}</p>
                    </div>
                </div>
            </div>

            {{-- Timestamps --}}
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Timeline</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Placed At</p>
                        <p class="text-slate-700 font-medium">{{ $order->created_at->format('M d, Y') }}</p>
                        <p class="text-slate-500 text-sm">{{ $order->created_at->format('h:i A') }}</p>
                    </div>
                    @if ($order->updated_at && $order->updated_at->ne($order->created_at))
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wide mb-1">Last Updated</p>
                            <p class="text-slate-700 font-medium">{{ $order->updated_at->format('M d, Y') }}</p>
                            <p class="text-slate-500 text-sm">{{ $order->updated_at->format('h:i A') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection
