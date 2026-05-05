@extends('layouts.app')

@section('title', 'Stripe Payment - The Lighthouse Cafe')

@section('content')
    <section class="py-16 bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Payment Header -->
            <div class="text-center mb-12">
                <div class="inline-block p-4 bg-white rounded-full shadow-lg mb-4">
                    <svg class="w-12 h-12 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
                <h1 class="text-4xl font-serif font-bold text-slate-800 mb-2">Secure Payment</h1>
                <p class="text-slate-600 text-lg">Complete your order with Stripe</p>
            </div>

            <!-- Payment Card -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                <!-- Payment Icon -->
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-8 text-center">
                    <svg class="w-16 h-16 text-white mx-auto" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 1C6.48 1 2 5.48 2 11s4.48 10 10 10 10-4.48 10-10S17.52 1 12 1zm-2 15l-5-5 1.41-1.41L10 13.17l7.59-7.59L19 7l-9 9z">
                        </path>
                    </svg>
                </div>

                <!-- Order Summary -->
                <div class="p-8">
                    <h2 class="text-2xl font-serif font-bold text-slate-800 mb-6">Order Summary</h2>

                    <!-- Customer Info -->
                    <div class="bg-slate-50 rounded-lg p-4 mb-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-slate-600 font-semibold">Name</p>
                                <p class="text-slate-800 font-bold">{{ $order->customer_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-slate-600 font-semibold">Email</p>
                                <p class="text-slate-800 font-bold">{{ $order->customer_email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-slate-600 font-semibold">Phone</p>
                                <p class="text-slate-800 font-bold">{{ $order->customer_phone }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-slate-600 font-semibold">Payment Method</p>
                                <p class="text-slate-800 font-bold">
                                    @if ($order->payment_method === 'card')
                                        <span class="text-blue-600">💳 Card</span>
                                    @elseif($order->payment_method === 'online')
                                        <span class="text-green-600">📱 Online Payment</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Items List -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-slate-800 mb-4">Items Ordered</h3>
                        <div class="space-y-3">
                            @foreach ($order->items as $item)
                                <div class="flex justify-between items-center pb-3 border-b border-slate-200">
                                    <div>
                                        <p class="font-semibold text-slate-800">{{ $item->dish_name }}</p>
                                        <p class="text-sm text-slate-600">Quantity: {{ $item->quantity }}</p>
                                    </div>
                                    <p class="font-bold text-amber-600">${{ number_format($item->subtotal, 2) }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Breakdown -->
                    <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-lg p-6 mb-6">
                        <div class="space-y-3">
                            <div class="flex justify-between text-slate-700">
                                <span>Subtotal:</span>
                                <span class="font-semibold">${{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-slate-700">
                                <span>Tax (8%):</span>
                                <span class="font-semibold">${{ number_format($order->tax, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-slate-700">
                                <span>Delivery Fee:</span>
                                <span class="font-semibold">${{ number_format($order->delivery_fee, 2) }}</span>
                            </div>
                            <div
                                class="border-t-2 border-slate-300 pt-3 flex justify-between text-2xl font-bold text-slate-800">
                                <span>Total:</span>
                                <span class="text-amber-600">${{ number_format($order->total, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Address -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <p class="text-sm text-blue-900 font-semibold mb-2">📍 Delivery Address</p>
                        <p class="text-blue-800">{{ $order->delivery_address }}</p>
                    </div>

                    @if ($order->special_instructions)
                        <!-- Special Instructions -->
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                            <p class="text-sm text-yellow-900 font-semibold mb-2">📝 Special Instructions</p>
                            <p class="text-yellow-800">{{ $order->special_instructions }}</p>
                        </div>
                    @endif

                    <!-- Payment Buttons -->
                    <div class="space-y-3">
                        <form action="{{ route('orders.stripe.checkout', $order->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-4 px-6 rounded-xl transition duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center justify-center gap-3">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z">
                                    </path>
                                </svg>
                                <span>Proceed to Stripe Payment</span>
                            </button>
                        </form>

                        <a href="{{ route('orders.checkout') }}"
                            class="w-full bg-slate-200 hover:bg-slate-300 text-slate-800 font-bold py-3 px-6 rounded-xl transition duration-300 text-center block">
                            ← Back to Checkout
                        </a>
                    </div>

                    <!-- Security Info -->
                    <div class="mt-8 pt-6 border-t border-slate-200 text-center">
                        <div class="flex items-center justify-center gap-2 text-sm text-slate-600 mb-3">
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 1C6.48 1 2 5.48 2 11s4.48 10 10 10 10-4.48 10-10S17.52 1 12 1zm-2 15l-5-5 1.41-1.41L10 13.17l7.59-7.59L19 7l-9 9z">
                                </path>
                            </svg>
                            <span>Your payment is processed securely by Stripe</span>
                        </div>
                        <p class="text-xs text-slate-500">
                            We never see your card details. All payments are encrypted and PCI-DSS compliant.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Trust Badges -->
            <div class="mt-8 text-center">
                <p class="text-slate-600 mb-4">Trusted payment method</p>
                <div class="flex items-center justify-center gap-6">
                    <svg class="w-12 h-12 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20 8H4V6h16m1-2H3c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z">
                        </path>
                    </svg>
                    <svg class="w-12 h-12 text-green-600" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M12 1C6.48 1 2 5.48 2 11s4.48 10 10 10 10-4.48 10-10S17.52 1 12 1zm-2 15l-5-5 1.41-1.41L10 13.17l7.59-7.59L19 7l-9 9z">
                        </path>
                    </svg>
                    <svg class="w-12 h-12 text-red-600" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M12 1C6.48 1 2 5.48 2 11s4.48 10 10 10 10-4.48 10-10S17.52 1 12 1zm-2 15l-5-5 1.41-1.41L10 13.17l7.59-7.59L19 7l-9 9z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        section {
            animation: fadeIn 0.3s ease-out;
        }
    </style>
@endsection
