@extends('layouts.app')

@section('title', 'Shopping Cart - The Lighthouse Cafe')

@section('content')
    <section class="py-16 bg-slate-50 min-h-screen" x-data="cartPageData()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl md:text-5xl font-serif font-bold text-slate-800 mb-2">Shopping Cart</h1>
                <p class="text-slate-600">Review your items before checkout</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <template x-if="cart.length === 0">
                        <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                            <div class="mb-6">
                                <svg class="w-24 h-24 mx-auto text-slate-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <h2 class="text-2xl font-serif font-bold text-slate-800 mb-4">Your cart is empty</h2>
                            <p class="text-slate-600 mb-8">Start adding some delicious items to your cart!</p>
                            <a href="{{ route('orders.index') }}"
                                class="inline-block bg-amber-500 hover:bg-amber-600 text-slate-900 font-bold px-8 py-3 rounded-lg transition">
                                Browse Menu
                            </a>
                        </div>
                    </template>

                    <template x-if="cart.length > 0">
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                            <div class="p-6 bg-gradient-to-r from-slate-800 to-slate-900 text-white">
                                <h2 class="text-2xl font-serif font-bold">Your Items (<span x-text="cart.length"></span>)
                                </h2>
                            </div>

                            <div class="divide-y divide-slate-200">
                                <template x-for="(item, index) in cart" :key="item.id">
                                    <div class="p-6 hover:bg-slate-50 transition">
                                        <div class="flex items-center gap-6">
                                            <!-- Dish Image -->
                                            <div class="flex-shrink-0">
                                                <img :src="item.image || '{{ asset('images/placeholder-dish.jpg') }}'"
                                                    :alt="item.name"
                                                    x-on:error="$event.target.src='{{ asset('images/placeholder-dish.jpg') }}'"
                                                    class="w-20 h-20 object-cover rounded-lg border-2 border-slate-200">
                                            </div>

                                            <!-- Item Details -->
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-xl font-serif font-bold text-slate-800 mb-1"
                                                    x-text="item.name"></h3>
                                                <p class="text-amber-600 font-bold text-lg">$<span
                                                        x-text="item.price.toFixed(2)"></span></p>
                                            </div>

                                            <!-- Quantity Controls -->
                                            <div class="flex items-center space-x-3">
                                                <button @click="decreaseQuantity(item.id)"
                                                    class="w-10 h-10 bg-slate-200 hover:bg-slate-300 rounded-lg font-bold text-slate-700 transition">
                                                    -
                                                </button>
                                                <input type="number" :value="item.quantity"
                                                    @input="updateQuantity(item.id, $event.target.value)" min="1"
                                                    max="99"
                                                    class="w-16 text-center font-bold text-lg border-2 border-slate-300 rounded-lg focus:border-amber-500 focus:outline-none">
                                                <button @click="increaseQuantity(item.id)"
                                                    class="w-10 h-10 bg-amber-500 hover:bg-amber-600 text-slate-900 rounded-lg font-bold transition">
                                                    +
                                                </button>
                                            </div>

                                            <!-- Subtotal -->
                                            <div class="text-right min-w-[100px]">
                                                <p class="text-sm text-slate-600 mb-1">Subtotal</p>
                                                <p class="text-2xl font-bold text-slate-800">$<span
                                                        x-text="(item.price * item.quantity).toFixed(2)"></span></p>
                                            </div>

                                            <!-- Remove Button -->
                                            <button @click="removeFromCart(item.id)"
                                                class="flex-shrink-0 w-10 h-10 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition flex items-center justify-center"
                                                title="Remove item">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <!-- Cart Actions -->
                            <div class="p-6 bg-slate-50 border-t border-slate-200">
                                <div class="flex flex-col sm:flex-row gap-4">
                                    <button @click="clearCart()"
                                        class="flex-1 bg-white hover:bg-slate-100 text-slate-700 font-semibold px-6 py-3 rounded-lg border-2 border-slate-300 transition">
                                        Clear Cart
                                    </button>
                                    <a href="{{ route('orders.index') }}"
                                        class="flex-1 bg-slate-700 hover:bg-slate-800 text-white font-semibold px-6 py-3 rounded-lg transition text-center">
                                        Continue Shopping
                                    </a>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Order Summary Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden sticky top-24">
                        <div class="p-6 bg-gradient-to-r from-amber-500 to-amber-600 text-slate-900">
                            <h2 class="text-2xl font-serif font-bold">Order Summary</h2>
                        </div>

                        <div class="p-6">
                            <template x-if="cart.length > 0">
                                <div>
                                    <!-- Price Breakdown -->
                                    <div class="space-y-4 mb-6">
                                        <div class="flex justify-between text-slate-700">
                                            <span>Subtotal (<span x-text="totalItems"></span> items):</span>
                                            <span class="font-semibold">$<span x-text="subtotal.toFixed(2)"></span></span>
                                        </div>
                                        <div class="flex justify-between text-slate-700">
                                            <span>Tax (8%):</span>
                                            <span class="font-semibold">$<span x-text="tax.toFixed(2)"></span></span>
                                        </div>
                                        <div class="flex justify-between text-slate-700">
                                            <span>Delivery Fee:</span>
                                            <span class="font-semibold">$<span
                                                    x-text="deliveryFee.toFixed(2)"></span></span>
                                        </div>

                                        <div class="border-t-2 border-slate-800 pt-4">
                                            <div class="flex justify-between items-center">
                                                <span class="text-xl font-bold text-slate-800">Total:</span>
                                                <span class="text-3xl font-bold text-amber-600">$<span
                                                        x-text="grandTotal.toFixed(2)"></span></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Promo Code -->
                                    <div class="mb-6">
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">Promo Code</label>
                                        <div class="flex gap-2">
                                            <input type="text" placeholder="Enter code"
                                                class="flex-1 px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:border-amber-500">
                                            <button
                                                class="bg-slate-700 hover:bg-slate-800 text-white px-4 py-2 rounded-lg font-semibold transition">
                                                Apply
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Checkout Button -->
                                    <a href="{{ route('orders.checkout') }}"
                                        class="block w-full bg-amber-500 hover:bg-amber-600 text-slate-900 text-center font-bold py-4 rounded-lg transition text-xl shadow-lg hover:shadow-xl transform hover:scale-105">
                                        Proceed to Checkout
                                    </a>

                                    <!-- Security Badge -->
                                    <div class="mt-6 text-center">
                                        <div class="inline-flex items-center text-sm text-slate-600">
                                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                            Secure Checkout
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <template x-if="cart.length === 0">
                                <div class="text-center py-8 text-slate-500">
                                    <p>Your cart is empty</p>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function cartPageData() {
            return {
                cart: JSON.parse(localStorage.getItem('cart') || '[]'),

                get totalItems() {
                    return this.cart.reduce((sum, item) => sum + item.quantity, 0);
                },

                get subtotal() {
                    return this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                },

                get tax() {
                    return this.subtotal * 0.08;
                },

                deliveryFee: 5.00,

                get grandTotal() {
                    return this.subtotal + this.tax + this.deliveryFee;
                },

                increaseQuantity(id) {
                    const item = this.cart.find(item => item.id === id);
                    if (item) {
                        item.quantity++;
                        this.saveCart();
                    }
                },

                decreaseQuantity(id) {
                    const item = this.cart.find(item => item.id === id);
                    if (item && item.quantity > 1) {
                        item.quantity--;
                        this.saveCart();
                    }
                },

                updateQuantity(id, value) {
                    const quantity = parseInt(value);
                    if (quantity > 0 && quantity <= 99) {
                        const item = this.cart.find(item => item.id === id);
                        if (item) {
                            item.quantity = quantity;
                            this.saveCart();
                        }
                    }
                },

                removeFromCart(id) {
                    if (confirm('Remove this item from cart?')) {
                        this.cart = this.cart.filter(item => item.id !== id);
                        this.saveCart();
                        this.showNotification('Item removed from cart');
                    }
                },

                clearCart() {
                    if (confirm('Are you sure you want to clear your entire cart?')) {
                        this.cart = [];
                        this.saveCart();
                        this.showNotification('Cart cleared');
                    }
                },

                saveCart() {
                    localStorage.setItem('cart', JSON.stringify(this.cart));
                },

                showNotification(message) {
                    const notification = document.createElement('div');
                    notification.className =
                        'fixed top-24 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                    notification.textContent = message;
                    document.body.appendChild(notification);
                    setTimeout(() => {
                        notification.style.opacity = '0';
                        notification.style.transition = 'opacity 0.3s';
                        setTimeout(() => notification.remove(), 300);
                    }, 2000);
                }
            }
        }
    </script>
@endsection
