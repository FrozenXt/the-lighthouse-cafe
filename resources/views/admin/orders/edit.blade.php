@extends('admin.layouts.app')

@section('title', 'Edit Order #' . $order->order_number)

@section('content')

    {{-- Page Header --}}
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.orders.show', $order) }}"
            class="text-slate-500 hover:text-slate-700 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h2 class="text-2xl font-serif font-bold text-slate-800">Edit Order</h2>
            <p class="text-slate-500 text-sm font-mono">{{ $order->order_number }}</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6">
            <ul class="list-disc list-inside text-red-700 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Left: Main Fields --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Customer Information --}}
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-5">Customer Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Customer Name</label>
                            <input type="text" name="customer_name"
                                value="{{ old('customer_name', $order->customer_name) }}"
                                class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-400 transition"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Phone</label>
                            <input type="text" name="customer_phone"
                                value="{{ old('customer_phone', $order->customer_phone) }}"
                                class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-400 transition">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Email</label>
                            <input type="email" name="customer_email"
                                value="{{ old('customer_email', $order->customer_email) }}"
                                class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-400 transition">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Delivery Address</label>
                            <textarea name="delivery_address" rows="2"
                                class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-400 transition resize-none">{{ old('delivery_address', $order->delivery_address) }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Special Instructions</label>
                            <textarea name="special_instructions" rows="3"
                                placeholder="Any special requests or notes..."
                                class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-400 transition resize-none">{{ old('special_instructions', $order->special_instructions) }}</textarea>
                        </div>

                    </div>
                </div>

                {{-- Order Items (read-only view) --}}
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-slate-800">Order Items</h3>
                        <span class="text-sm text-slate-500">{{ $order->items->count() }} items</span>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @foreach ($order->items as $item)
                            <div class="flex justify-between items-center px-6 py-3">
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $item->dish_name }}</p>
                                    <p class="text-sm text-slate-500">{{ $item->quantity }} &times; ${{ number_format($item->price, 2) }}</p>
                                </div>
                                <span class="font-bold text-amber-600">${{ number_format($item->subtotal, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="px-6 py-4 bg-slate-50 flex justify-between font-bold">
                        <span class="text-slate-700">Total</span>
                        <span class="text-amber-600 text-lg">${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>

            </div>

            {{-- Right: Status & Payment --}}
            <div class="space-y-6">

                {{-- Order Status --}}
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-5">Order Status</h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Status</label>
                            <select name="status"
                                class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-400 transition bg-white">
                                @foreach ([
                                    'pending'   => '⏳ Pending',
                                    'confirmed' => '✓ Confirmed',
                                    'preparing' => '👨‍🍳 Preparing',
                                    'ready'     => '✓ Ready',
                                    'delivered' => '🚚 Delivered',
                                    'cancelled' => '✗ Cancelled',
                                ] as $value => $label)
                                    <option value="{{ $value }}" {{ old('status', $order->status) === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Payment Status</label>
                            <select name="payment_status"
                                class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-400 transition bg-white">
                                <option value="pending"  {{ old('payment_status', $order->payment_status) === 'pending'  ? 'selected' : '' }}>Pending</option>
                                <option value="paid"     {{ old('payment_status', $order->payment_status) === 'paid'     ? 'selected' : '' }}>Paid</option>
                                <option value="failed"   {{ old('payment_status', $order->payment_status) === 'failed'   ? 'selected' : '' }}>Failed</option>
                                <option value="refunded" {{ old('payment_status', $order->payment_status) === 'refunded' ? 'selected' : '' }}>Refunded</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Payment Method</label>
                            <select name="payment_method"
                                class="w-full border border-slate-300 rounded-lg px-4 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-400 transition bg-white">
                                <option value="cash"   {{ old('payment_method', $order->payment_method) === 'cash'   ? 'selected' : '' }}>Cash</option>
                                <option value="card"   {{ old('payment_method', $order->payment_method) === 'card'   ? 'selected' : '' }}>Card</option>
                                <option value="online" {{ old('payment_method', $order->payment_method) === 'online' ? 'selected' : '' }}>Online</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Order Meta (read-only) --}}
                <div class="bg-slate-50 rounded-xl border border-slate-200 p-6">
                    <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wide mb-4">Order Info</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Order #</span>
                            <span class="font-mono font-bold text-slate-800">{{ $order->order_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Placed</span>
                            <span class="text-slate-700">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Items</span>
                            <span class="text-slate-700">{{ $order->items->count() }}</span>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex flex-col gap-3">
                    <button type="submit"
                        class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 rounded-xl transition text-sm shadow">
                        Save Changes
                    </button>
                    <a href="{{ route('admin.orders.show', $order) }}"
                        class="w-full text-center bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold py-3 rounded-xl transition text-sm">
                        Cancel
                    </a>
                </div>

            </div>
        </div>
    </form>

@endsection
