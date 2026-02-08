@extends('layouts.app')

@section('title', 'Order Confirmed - The Lighthouse Cafe')

@section('content')
    <section class="py-20 bg-linear-to-br from-green-50 to-emerald-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success Message -->
            <div class="text-center mb-12">
                <div class="mb-6 flex justify-center">
                    <div class="w-24 h-24 bg-green-500 rounded-full flex items-center justify-center animate-bounce">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
                <h1 class="text-5xl md:text-6xl font-serif font-bold text-green-700 mb-4">Order Confirmed!</h1>
                <p class="text-xl text-slate-600 mb-2">Thank you for your order at The Lighthouse Cafe</p>
                <p class="text-slate-600">Your delicious meal will be prepared with care and delivered soon</p>
            </div>

            <!-- Order Details -->
            <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-12 mb-8">
                <!-- Order Number & Date -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 pb-8 border-b-2 border-slate-200">
                    <div>
                        <p class="text-slate-600 text-sm font-semibold uppercase mb-2">Order Number</p>
                        <p class="text-3xl font-bold text-slate-800">#{{ $order->id }}</p>
                    </div>
                    <div>
                        <p class="text-slate-600 text-sm font-semibold uppercase mb-2">Order Date</p>
                        <p class="text-lg text-slate-800">{{ $order->created_at->format('M d, Y \a\t h:i A') }}</p>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="mb-8">
                    <h2 class="text-2xl font-serif font-bold text-slate-800 mb-6">Delivery Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <p class="text-slate-600 text-sm font-semibold uppercase mb-2">Customer Name</p>
                            <p class="text-lg text-slate-800">{{ $order->customer_name }}</p>
                        </div>
                        <div>
                            <p class="text-slate-600 text-sm font-semibold uppercase mb-2">Phone</p>
                            <p class="text-lg text-slate-800">{{ $order->customer_phone }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-slate-600 text-sm font-semibold uppercase mb-2">Delivery Address</p>
                            <p class="text-lg text-slate-800">{{ $order->delivery_address }}</p>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="mb-8 pb-8 border-b-2 border-slate-200">
                    <h2 class="text-2xl font-serif font-bold text-slate-800 mb-6">Order Items</h2>
                    <div class="space-y-4">
                        @foreach ($order->items as $item)
                            <div class="flex justify-between items-center p-4 bg-slate-50 rounded-lg">
                                <div>
                                    <h3 class="font-semibold text-slate-800">{{ $item->dish_name }}</h3>
                                    <p class="text-sm text-slate-600">Quantity: {{ $item->quantity }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-amber-600">${{ number_format($item->subtotal, 2) }}</p>
                                    <p class="text-sm text-slate-600">${{ number_format($item->price, 2) }} each</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="mb-8">
                    <h2 class="text-2xl font-serif font-bold text-slate-800 mb-6">Order Summary</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between text-lg text-slate-700">
                            <span>Subtotal:</span>
                            <span class="font-semibold">${{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-lg text-slate-700">
                            <span>Tax (8%):</span>
                            <span class="font-semibold">${{ number_format($order->tax, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-lg text-slate-700">
                            <span>Delivery Fee:</span>
                            <span class="font-semibold">${{ number_format($order->delivery_fee, 2) }}</span>
                        </div>
                        <div
                            class="flex justify-between text-2xl font-bold text-slate-800 pt-4 border-t-2 border-slate-300">
                            <span>Total:</span>
                            <span class="text-amber-600">${{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment & Status -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-blue-50 rounded-lg p-6 border border-blue-200">
                        <p class="text-slate-600 text-sm font-semibold uppercase mb-2">Payment Method</p>
                        <p class="text-xl font-bold text-slate-800">
                            @if ($order->payment_method === 'cash')
                                💵 Cash on Delivery
                            @elseif ($order->payment_method === 'card')
                                💳 Credit/Debit Card
                            @else
                                📱 Online Payment
                            @endif
                        </p>
                    </div>
                    <div class="bg-yellow-50 rounded-lg p-6 border border-yellow-200">
                        <p class="text-slate-600 text-sm font-semibold uppercase mb-2">Order Status</p>
                        <p class="text-xl font-bold text-slate-800">
                            <span class="px-3 py-1 rounded-full text-sm {{ $order->status_color }} inline-block">
                                {{ ucfirst($order->status) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Special Instructions -->
            @if ($order->special_instructions)
                <div class="bg-amber-50 rounded-2xl border-2 border-amber-200 p-8 mb-8">
                    <h3 class="text-lg font-bold text-slate-800 mb-3">Special Instructions</h3>
                    <p class="text-slate-700">{{ $order->special_instructions }}</p>
                </div>
            @endif

            <!-- Next Steps -->
            <div class="bg-slate-50 rounded-2xl p-8 mb-8">
                <h2 class="text-2xl font-serif font-bold text-slate-800 mb-6">What Happens Next?</h2>
                <div class="space-y-4">
                    <div class="flex gap-4">
                        <div
                            class="w-12 h-12 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold flex-shrink-0">
                            1</div>
                        <div>
                            <h3 class="font-bold text-slate-800 mb-1">Order Confirmed</h3>
                            <p class="text-slate-600">Your order has been received and is being prepared by our team.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div
                            class="w-12 h-12 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold flex-shrink-0">
                            2</div>
                        <div>
                            <h3 class="font-bold text-slate-800 mb-1">Preparing Your Food</h3>
                            <p class="text-slate-600">Our chefs are carefully preparing your delicious meal with fresh
                                ingredients.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div
                            class="w-12 h-12 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold flex-shrink-0">
                            3</div>
                        <div>
                            <h3 class="font-bold text-slate-800 mb-1">On Its Way</h3>
                            <p class="text-slate-600">Your order will be packaged and dispatched to your delivery address.
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div
                            class="w-12 h-12 bg-green-500 text-white rounded-full flex items-center justify-center font-bold flex-shrink-0">
                            4</div>
                        <div>
                            <h3 class="font-bold text-slate-800 mb-1">Delivered!</h3>
                            <p class="text-slate-600">Your meal arrives fresh and ready to enjoy. Bon appétit!</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="{{ route('orders.index') }}"
                    class="bg-amber-500 hover:bg-amber-600 text-slate-900 font-bold py-4 rounded-lg transition text-center">
                    Order More
                </a>
                <a href="{{ route('menu') }}"
                    class="bg-slate-700 hover:bg-slate-800 text-white font-bold py-4 rounded-lg transition text-center">
                    Browse Menu
                </a>
            </div>

            <!-- Contact Info -->
            <div class="text-center mt-12 pt-8 border-t border-slate-300">
                <p class="text-slate-600 mb-4">Have questions about your order?</p>
                <div class="space-y-2 text-slate-700">
                    <p class="font-semibold">📞 Call us: (617) 395-8200</p>
                    <p class="font-semibold">✉️ Email: info@lighthousecafe.com</p>
                </div>
            </div>
        </div>
    </section>
@endsection
