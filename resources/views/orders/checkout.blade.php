@extends('layouts.app')

@section('title', 'Checkout - The Lighthouse Cafe')

@section('content')
    <section class="py-16 bg-slate-50 min-h-screen" x-data="checkoutData()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-serif font-bold text-slate-800 mb-8 text-center">Checkout</h1>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Order Form -->
                <div class="lg:col-span-2">
                    <form @submit.prevent="submitOrder" class="bg-white rounded-2xl shadow-xl p-8">
                        <h2 class="text-2xl font-serif font-bold text-slate-800 mb-6">Delivery Information</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-slate-700 font-semibold mb-2">Full Name *</label>
                                <input type="text" x-model="formData.customer_name" required
                                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-200">
                            </div>

                            <div>
                                <label class="block text-slate-700 font-semibold mb-2">Phone *</label>
                                <input type="tel" x-model="formData.customer_phone" required
                                    class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-200">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-slate-700 font-semibold mb-2">Email *</label>
                            <input type="email" x-model="formData.customer_email" required
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-200">
                        </div>

                        <div class="mb-6">
                            <label class="block text-slate-700 font-semibold mb-2">Delivery Address *</label>
                            <textarea x-model="formData.delivery_address" required rows="3"
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-200"></textarea>
                        </div>

                        <div class="mb-6">
                            <label class="block text-slate-700 font-semibold mb-2">Payment Method *</label>
                            <div class="grid grid-cols-3 gap-4">
                                <label
                                    class="flex items-center justify-center p-4 border-2 rounded-lg cursor-pointer transition"
                                    :class="formData.payment_method === 'cash' ? 'border-amber-500 bg-amber-50' :
                                        'border-slate-300'">
                                    <input type="radio" x-model="formData.payment_method" value="cash" class="sr-only">
                                    <div class="text-center">
                                        <span class="text-2xl">💵</span>
                                        <p class="font-semibold mt-2">Cash</p>
                                    </div>
                                </label>

                                <label
                                    class="flex items-center justify-center p-4 border-2 rounded-lg cursor-pointer transition"
                                    :class="formData.payment_method === 'card' ? 'border-amber-500 bg-amber-50' :
                                        'border-slate-300'">
                                    <input type="radio" x-model="formData.payment_method" value="card" class="sr-only">
                                    <div class="text-center">
                                        <span class="text-2xl">💳</span>
                                        <p class="font-semibold mt-2">Card</p>
                                    </div>
                                </label>

                                <label
                                    class="flex items-center justify-center p-4 border-2 rounded-lg cursor-pointer transition"
                                    :class="formData.payment_method === 'online' ? 'border-amber-500 bg-amber-50' :
                                        'border-slate-300'">
                                    <input type="radio" x-model="formData.payment_method" value="online" class="sr-only">
                                    <div class="text-center">
                                        <span class="text-2xl">📱</span>
                                        <p class="font-semibold mt-2">Online</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-slate-700 font-semibold mb-2">Special Instructions (Optional)</label>
                            <textarea x-model="formData.special_instructions" rows="3"
                                placeholder="Any special requests or dietary restrictions..."
                                class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-200"></textarea>
                        </div>

                        <button type="submit" :disabled="cart.length === 0" x-data="{ submitting: false }"
                            @click="submitting = true"
                            class="w-full bg-amber-500 hover:bg-amber-600 disabled:bg-slate-300 text-slate-900 font-bold py-4 rounded-lg transition text-xl"
                            x-text="submitting ? 'Processing Order...' : 'Place Order - $' + grandTotal.toFixed(2)">
                            Place Order - $<span x-text="grandTotal.toFixed(2)"></span>
                        </button>
                    </form>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-xl p-8 sticky top-24">
                        <h2 class="text-2xl font-serif font-bold text-slate-800 mb-6">Order Summary</h2>

                        <div class="space-y-4 mb-6">
                            <template x-for="item in cart" :key="item.id">
                                <div class="flex items-center gap-4 border-b border-slate-200 pb-4">
                                    <img :src="item.image || '{{ asset('images/placeholder-dish.jpg') }}'"
                                        :alt="item.name"
                                        x-on:error="$event.target.src='{{ asset('images/placeholder-dish.jpg') }}'"
                                        class="w-16 h-16 object-cover rounded-lg border border-slate-200 flex-shrink-0">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-slate-800" x-text="item.name"></h4>
                                        <p class="text-sm text-slate-600">Qty: <span x-text="item.quantity"></span></p>
                                        <p class="text-sm text-amber-600 font-semibold">$<span
                                                x-text="item.price.toFixed(2)"></span> each</p>
                                    </div>
                                    <span class="font-bold text-amber-600 text-lg">$<span
                                            x-text="(item.price * item.quantity).toFixed(2)"></span></span>
                                </div>
                            </template>
                        </div>

                        <div class="space-y-3 border-t-2 border-slate-800 pt-4">
                            <div class="flex justify-between text-slate-700">
                                <span>Subtotal:</span>
                                <span class="font-semibold">$<span x-text="subtotal.toFixed(2)"></span></span>
                            </div>
                            <div class="flex justify-between text-slate-700">
                                <span>Tax (8%):</span>
                                <span class="font-semibold">$<span x-text="tax.toFixed(2)"></span></span>
                            </div>
                            <div class="flex justify-between text-slate-700">
                                <span>Delivery Fee:</span>
                                <span class="font-semibold">$<span x-text="deliveryFee.toFixed(2)"></span></span>
                            </div>
                            <div
                                class="flex justify-between text-2xl font-bold text-slate-800 pt-3 border-t border-slate-300">
                                <span>Total:</span>
                                <span class="text-amber-600">$<span x-text="grandTotal.toFixed(2)"></span></span>
                            </div>
                        </div>

                        <a href="{{ route('orders.index') }}"
                            class="block mt-6 text-center text-amber-600 hover:text-amber-700 font-semibold">
                            ← Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function checkoutData() {
            return {
                cart: JSON.parse(localStorage.getItem('cart') || '[]'),
                formData: {
                    customer_name: '',
                    customer_email: '',
                    customer_phone: '',
                    delivery_address: '',
                    payment_method: 'cash',
                    special_instructions: ''
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

                async submitOrder() {
                    if (this.cart.length === 0) {
                        alert('Your cart is empty!');
                        return;
                    }

                    // Validate form
                    if (!this.formData.customer_name || !this.formData.customer_email || !this.formData
                        .customer_phone || !this.formData.delivery_address) {
                        alert('Please fill in all required fields!');
                        return;
                    }

                    const formData = new FormData();
                    formData.append('customer_name', this.formData.customer_name);
                    formData.append('customer_email', this.formData.customer_email);
                    formData.append('customer_phone', this.formData.customer_phone);
                    formData.append('delivery_address', this.formData.delivery_address);
                    formData.append('payment_method', this.formData.payment_method);
                    formData.append('special_instructions', this.formData.special_instructions);
                    formData.append('cart', JSON.stringify(this.cart));
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content'));

                    try {
                        const response = await fetch('{{ route('orders.store') }}', {
                            method: 'POST',
                            body: formData
                        });

                        const data = await response.json();

                        if (response.ok && data.success) {
                            localStorage.removeItem('cart');
                            window.location.href = data.redirect;
                        } else {
                            alert(data.message || 'Failed to place order. Please try again.');
                            console.error('Order error:', data);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    }
                }
            }
        }
    </script>
@endsection
