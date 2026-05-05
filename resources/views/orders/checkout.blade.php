@extends('layouts.app')

@section('content')

<!-- Hero -->
<div class="relative h-48 bg-cover bg-center"
    style="background-image: url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=1920&h=400&fit=crop');">
    <div class="absolute inset-0 bg-gradient-to-r from-slate-900/90 to-slate-800/70"></div>
    <div class="relative h-full flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white w-full">
            <h1 class="text-4xl md:text-5xl font-serif font-bold text-amber-400">Checkout</h1>
            <p class="text-slate-200 mt-1">Complete your order below</p>
        </div>
    </div>
</div>

<section class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8" x-data="checkoutForm()">

        <!-- Empty cart warning (shown briefly before redirect) -->
        <div x-show="cartEmpty" class="text-center py-20">
            <p class="text-slate-500 text-lg">Your cart is empty. Redirecting...</p>
        </div>

        <div x-show="!cartEmpty">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- ── LEFT: Customer Details ───────────────────────────── -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Customer Info -->
                    <div class="bg-white rounded-xl shadow border border-slate-200 p-6">
                        <h2 class="text-xl font-bold text-slate-800 mb-5 flex items-center gap-2">
                            <span class="bg-amber-500 text-white w-7 h-7 rounded-full flex items-center justify-center text-sm font-bold">1</span>
                            Your Details
                        </h2>

                        <div class="space-y-4">
                            <!-- Full Name -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                                <input
                                    type="text"
                                    x-model="customerName"
                                    placeholder="Enter your full name"
                                    class="w-full border border-slate-300 rounded-lg px-4 py-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition">
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                                <input
                                    type="email"
                                    x-model="customerEmail"
                                    placeholder="you@example.com"
                                    class="w-full border border-slate-300 rounded-lg px-4 py-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition">
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Phone Number <span class="text-red-500">*</span></label>
                                <input
                                    type="tel"
                                    x-model="customerPhone"
                                    placeholder="+1 (555) 000-0000"
                                    class="w-full border border-slate-300 rounded-lg px-4 py-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition">
                            </div>

                            <!-- Delivery Address -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Delivery Address <span class="text-red-500">*</span></label>
                                <textarea
                                    x-model="deliveryAddress"
                                    rows="3"
                                    placeholder="Enter your full delivery address"
                                    class="w-full border border-slate-300 rounded-lg px-4 py-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition resize-none"></textarea>
                            </div>

                            <!-- Special Instructions -->
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Special Instructions <span class="text-slate-400 font-normal">(optional)</span></label>
                                <textarea
                                    x-model="specialInstructions"
                                    rows="2"
                                    placeholder="Allergies, preferences, gate code..."
                                    class="w-full border border-slate-300 rounded-lg px-4 py-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition resize-none"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-white rounded-xl shadow border border-slate-200 p-6">
                        <h2 class="text-xl font-bold text-slate-800 mb-5 flex items-center gap-2">
                            <span class="bg-amber-500 text-white w-7 h-7 rounded-full flex items-center justify-center text-sm font-bold">2</span>
                            Payment Method
                        </h2>

                        <div class="grid grid-cols-2 gap-4">
                            <button
                                type="button"
                                @click="paymentMethod = 'cash'"
                                :class="paymentMethod === 'cash'
                                    ? 'border-amber-500 bg-amber-50 text-amber-700 shadow-md'
                                    : 'border-slate-200 text-slate-600 hover:border-slate-300 hover:bg-slate-50'"
                                class="border-2 rounded-xl p-5 text-center font-semibold transition-all duration-200">
                                <div class="text-3xl mb-2">🏠</div>
                                <div>Cash on Delivery</div>
                                <div class="text-xs font-normal text-slate-500 mt-1">Pay when you receive</div>
                            </button>

                            <button
                                type="button"
                                @click="paymentMethod = 'card'"
                                :class="paymentMethod === 'card'
                                    ? 'border-amber-500 bg-amber-50 text-amber-700 shadow-md'
                                    : 'border-slate-200 text-slate-600 hover:border-slate-300 hover:bg-slate-50'"
                                class="border-2 rounded-xl p-5 text-center font-semibold transition-all duration-200">
                                <div class="text-3xl mb-2">💳</div>
                                <div>Card / Online</div>
                                <div class="text-xs font-normal text-slate-500 mt-1">Secure payment via Stripe</div>
                            </button>
                        </div>

                        <!-- Stripe info note -->
                        <div x-show="paymentMethod === 'card'" x-transition class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4 flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20A10 10 0 0012 2z"/>
                            </svg>
                            <p class="text-blue-700 text-sm">You'll be securely redirected to Stripe to complete your payment. Your card details are never stored on our servers.</p>
                        </div>
                    </div>
                </div>

                <!-- ── RIGHT: Order Summary ─────────────────────────────── -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow border border-slate-200 p-6 sticky top-6">
                        <h2 class="text-xl font-bold text-slate-800 mb-5 flex items-center gap-2">
                            <span class="bg-amber-500 text-white w-7 h-7 rounded-full flex items-center justify-center text-sm font-bold">3</span>
                            Order Summary
                        </h2>

                        <!-- Cart Items -->
                        <div class="space-y-3 mb-5 max-h-60 overflow-y-auto">
                            <template x-for="item in cart" :key="item.id">
                                <div class="flex justify-between items-start text-sm">
                                    <div class="flex-1 pr-2">
                                        <span class="font-semibold text-slate-800" x-text="item.name"></span>
                                        <span class="text-slate-400 ml-1">x<span x-text="item.quantity"></span></span>
                                    </div>
                                    <span class="text-slate-700 font-medium shrink-0">
                                        $<span x-text="(item.price * item.quantity).toFixed(2)"></span>
                                    </span>
                                </div>
                            </template>
                        </div>

                        <!-- Totals Breakdown -->
                        <div class="border-t border-slate-200 pt-4 space-y-2 text-sm">
                            <div class="flex justify-between text-slate-600">
                                <span>Subtotal</span>
                                <span>$<span x-text="subtotal.toFixed(2)"></span></span>
                            </div>
                            <div class="flex justify-between text-slate-600">
                                <span>Tax (8%)</span>
                                <span>$<span x-text="tax.toFixed(2)"></span></span>
                            </div>
                            <div class="flex justify-between text-slate-600">
                                <span>Delivery Fee</span>
                                <span>$<span x-text="deliveryFee.toFixed(2)"></span></span>
                            </div>
                            <div class="flex justify-between text-lg font-bold text-slate-800 border-t border-slate-200 pt-3 mt-3">
                                <span>Total</span>
                                <span class="text-amber-600">$<span x-text="total.toFixed(2)"></span></span>
                            </div>
                        </div>

                        <!-- Error Message -->
                        <div x-show="errorMessage" x-transition
                            class="mt-4 bg-red-50 border border-red-300 text-red-700 rounded-lg p-3 text-sm">
                            <p x-text="errorMessage"></p>
                        </div>

                        <!-- Submit Button -->
                        <button
                            type="button"
                            @click="submitPayment()"
                            :disabled="loading"
                            class="mt-6 w-full bg-amber-500 hover:bg-amber-600 disabled:opacity-50 disabled:cursor-not-allowed text-slate-900 font-bold py-4 rounded-xl transition-all duration-200 text-lg shadow-lg">

                            <span x-show="!loading" class="flex items-center justify-center gap-2">
                                <span x-show="paymentMethod === 'cash'">🏠 Place Order</span>
                                <span x-show="paymentMethod === 'card'">💳 Pay via Stripe</span>
                                <span class="font-bold">— $<span x-text="total.toFixed(2)"></span></span>
                            </span>

                            <span x-show="loading" class="flex items-center justify-center gap-2">
                                <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                                </svg>
                                Processing...
                            </span>
                        </button>

                        <p class="text-center text-xs text-slate-400 mt-3">
                            🔒 Your information is safe and encrypted
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
function checkoutForm() {
    return {
        paymentMethod: 'cash',
        loading: false,
        errorMessage: '',

        // Customer fields
        customerName: '',
        customerEmail: '',
        customerPhone: '',
        deliveryAddress: '',
        specialInstructions: '',

        // Cart from localStorage
        get cart() {
            return JSON.parse(localStorage.getItem('cart') || '[]');
        },

        get subtotal() {
            return this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        },

        get tax() {
            return this.subtotal * 0.08;
        },

        get deliveryFee() {
            return 5.00;
        },

        get total() {
            return this.subtotal + this.tax + this.deliveryFee;
        },

        get cartEmpty() {
            return this.cart.length === 0;
        },

        init() {
            if (this.cartEmpty) {
                setTimeout(() => {
                    window.location.href = '{{ route("orders.index") }}';
                }, 1500);
            }
        },

        async submitPayment() {
            this.errorMessage = '';

            // Validate required fields
            if (!this.customerName.trim()) {
                this.errorMessage = 'Please enter your full name.';
                return;
            }
            if (!this.customerEmail.trim()) {
                this.errorMessage = 'Please enter your email address.';
                return;
            }
            if (!this.customerPhone.trim()) {
                this.errorMessage = 'Please enter your phone number.';
                return;
            }
            if (!this.deliveryAddress.trim()) {
                this.errorMessage = 'Please enter your delivery address.';
                return;
            }
            if (this.cartEmpty) {
                this.errorMessage = 'Your cart is empty.';
                return;
            }

            this.loading = true;

            try {
                const response = await fetch('{{ route("orders.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        customer_name:        this.customerName.trim(),
                        customer_email:       this.customerEmail.trim(),
                        customer_phone:       this.customerPhone.trim(),
                        delivery_address:     this.deliveryAddress.trim(),
                        payment_method:       this.paymentMethod,
                        special_instructions: this.specialInstructions.trim(),
                        cart:                 JSON.stringify(this.cart),
                    }),
                });

                const data = await response.json();

                if (!data.success) {
                    this.errorMessage = data.message || 'Something went wrong. Please try again.';
                    this.loading = false;
                    return;
                }

                // Clear cart
                localStorage.removeItem('cart');
                window.dispatchEvent(new CustomEvent('cart-updated'));

                if (this.paymentMethod === 'cash') {
                    window.location.href = data.redirect;
                } else {
                    // Redirect to Stripe hosted checkout
                    window.location.href = data.checkout_url;
                }

            } catch (error) {
                console.error('Checkout error:', error);
                this.errorMessage = 'A network error occurred. Please check your connection and try again.';
                this.loading = false;
            }
        }
    }
}
</script>

@endsection
