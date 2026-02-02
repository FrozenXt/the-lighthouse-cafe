@extends('layouts.app')

@section('title', 'Order Online - The Lighthouse Cafe')


<!-- Hero -->
<div class="relative h-80 bg-cover bg-center"
    style="background-image: url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=1920&h=600&fit=crop');">
    <div class="absolute inset-0 bg-gradient-to-r from-slate-900/90 to-slate-800/70"></div>
    <div class="relative h-full flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white w-full">
            <h1 class="text-5xl md:text-6xl font-serif font-bold mb-4 text-amber-400">Order Online</h1>
            <p class="text-xl text-slate-200">Fresh, delicious food delivered to your doorstep</p>
        </div>
    </div>
</div>

<!-- Cart Summary (Fixed) -->
<div id="cart-summary"
    class="fixed bottom-0 left-0 right-0 bg-gradient-to-r from-slate-800 to-slate-900 text-white p-4 shadow-2xl border-t-2 border-amber-500 z-40 transform transition-transform duration-300"
    x-data="cartSummary()" x-show="cartCount > 0" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0" style="display: none;">
    <div class="max-w-7xl mx-auto flex items-center justify-between flex-wrap gap-4">
        <div class="flex items-center space-x-6">
            <div class="bg-amber-500 text-slate-900 px-4 py-2 rounded-full font-bold">
                <span x-text="cartCount"></span> Items
            </div>
            <div class="text-xl font-bold">
                Total: $<span x-text="cartTotal.toFixed(2)"></span>
            </div>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('orders.cart') }}"
                class="bg-slate-700 hover:bg-slate-600 px-6 py-3 rounded-lg font-semibold transition">
                View Cart
            </a>
            <a href="{{ route('orders.checkout') }}"
                class="bg-amber-500 hover:bg-amber-600 text-slate-900 px-8 py-3 rounded-lg font-bold transition">
                Checkout
            </a>
        </div>
    </div>
</div>

<!-- Menu Section -->
<section class="py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ activeCategory: 'all' }">

        <!-- Category Filter -->
        <div class="flex flex-wrap justify-center gap-4 mb-12">
            <button @click="activeCategory = 'all'"
                :class="activeCategory === 'all' ? 'bg-amber-500 text-slate-900' :
                    'bg-white text-slate-700 hover:bg-slate-100'"
                class="px-6 py-3 rounded-lg font-semibold transition shadow-lg">
                All Menu
            </button>
            @foreach ($dishes as $category => $items)
                <button @click="activeCategory = '{{ strtolower(str_replace(' ', '-', $category)) }}'"
                    :class="activeCategory === '{{ strtolower(str_replace(' ', '-', $category)) }}' ?
                        'bg-amber-500 text-slate-900' : 'bg-white text-slate-700 hover:bg-slate-100'"
                    class="px-6 py-3 rounded-lg font-semibold transition shadow-lg">
                    {{ $category }} ({{ count($items) }})
                </button>
            @endforeach
        </div>

        <!-- Menu Items -->
        @foreach ($dishes as $category => $items)
            <div x-show="activeCategory === 'all' || activeCategory === '{{ strtolower(str_replace(' ', '-', $category)) }}'"
                x-transition class="mb-16">
                <h2 class="text-4xl font-serif font-bold text-slate-800 mb-8 pb-4 border-b-2 border-amber-500">
                    {{ $category }}
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" x-data="orderActions()">
                    @foreach ($items as $dish)
                        <div
                            class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 border border-slate-200">
                            <div class="relative h-48 overflow-hidden">
                                <img src="{{ $dish->image }}" alt="{{ $dish->name }}"
                                    class="w-full h-full object-cover hover:scale-110 transition duration-500">
                                <div
                                    class="absolute top-4 right-4 bg-amber-500 text-slate-900 px-3 py-1 rounded-full text-sm font-bold">
                                    ⭐ {{ $dish->rating }}
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-2xl font-serif font-bold text-slate-800 mb-2">{{ $dish->name }}</h3>
                                <p class="text-slate-600 mb-4 line-clamp-2">{{ $dish->description }}</p>
                                <div class="flex justify-between items-center">
                                    <span
                                        class="text-3xl font-bold text-amber-600">${{ number_format($dish->price, 2) }}</span>
                                    <button
                                        @click="addToCart({{ $dish->id }}, '{{ addslashes($dish->name) }}', {{ $dish->price }})"
                                        class="bg-amber-500 hover:bg-amber-600 text-slate-900 font-bold px-6 py-2 rounded-lg transition transform hover:scale-105">
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- Cart Modal -->
<div x-data="cartModal()" x-show="showCart" @show-cart.window="showCart = true" @close-cart.window="showCart = false"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4"
    style="display: none;">
    <div @click.away="showCart = false" class="bg-white rounded-2xl max-w-2xl w-full max-h-[80vh] overflow-hidden">
        <div class="p-6 bg-gradient-to-r from-slate-800 to-slate-900 text-white flex justify-between items-center">
            <h2 class="text-3xl font-serif font-bold">Your Cart</h2>
            <button @click="showCart = false" class="text-white hover:text-amber-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="p-6 overflow-y-auto max-h-96">
            <template x-if="cart.length === 0">
                <div class="text-center py-12 text-slate-500">
                    <p class="text-xl">Your cart is empty</p>
                </div>
            </template>

            <template x-if="cart.length > 0">
                <div>
                    <template x-for="item in cart" :key="item.id">
                        <div class="flex items-center justify-between border-b border-slate-200 py-4">
                            <div class="flex-1">
                                <h4 class="font-bold text-slate-800" x-text="item.name"></h4>
                                <p class="text-amber-600 font-semibold">$<span x-text="item.price.toFixed(2)"></span>
                                </p>
                            </div>
                            <div class="flex items-center space-x-4">
                                <button @click="decreaseQuantity(item.id)"
                                    class="bg-slate-200 hover:bg-slate-300 w-8 h-8 rounded-full font-bold">-</button>
                                <span class="font-bold text-lg" x-text="item.quantity"></span>
                                <button @click="increaseQuantity(item.id)"
                                    class="bg-amber-500 hover:bg-amber-600 text-white w-8 h-8 rounded-full font-bold">+</button>
                                <button @click="removeFromCart(item.id)" class="text-red-500 hover:text-red-700 ml-4">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </template>

                    <div class="mt-6 pt-6 border-t-2 border-slate-800">
                        <div class="flex justify-between text-xl font-bold text-slate-800 mb-4">
                            <span>Total:</span>
                            <span class="text-amber-600">$<span x-text="cartTotal.toFixed(2)"></span></span>
                        </div>
                        <a href="{{ route('orders.checkout') }}"
                            class="block w-full bg-amber-500 hover:bg-amber-600 text-slate-900 text-center font-bold py-4 rounded-lg transition">
                            Proceed to Checkout
                        </a>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>

<script>
    // Cart storage helper
    const CartStorage = {
        get() {
            return JSON.parse(localStorage.getItem('cart') || '[]');
        },
        save(cart) {
            localStorage.setItem('cart', JSON.stringify(cart));
            window.dispatchEvent(new CustomEvent('cart-updated'));
        }
    };

    // Order actions (Add to cart)
    function orderActions() {
        return {
            addToCart(id, name, price) {
                let cart = CartStorage.get();
                const existingItem = cart.find(item => item.id === id);

                if (existingItem) {
                    existingItem.quantity++;
                } else {
                    cart.push({
                        id,
                        name,
                        price,
                        quantity: 1
                    });
                }

                CartStorage.save(cart);
                this.showNotification('✓ Added to cart!');
            },

            showNotification(message) {
                const notification = document.createElement('div');
                notification.className =
                    'fixed top-24 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-fade-in';
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

    // Cart summary (fixed bottom bar)
    function cartSummary() {
        return {
            cart: CartStorage.get(),

            init() {
                window.addEventListener('cart-updated', () => {
                    this.cart = CartStorage.get();
                });
            },

            get cartCount() {
                return this.cart.reduce((sum, item) => sum + item.quantity, 0);
            },

            get cartTotal() {
                return this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            },

            viewCart() {
                window.dispatchEvent(new CustomEvent('show-cart'));
            }
        }
    }

    // Cart modal
    function cartModal() {
        return {
            showCart: false,
            cart: CartStorage.get(),

            init() {
                window.addEventListener('cart-updated', () => {
                    this.cart = CartStorage.get();
                });
            },

            get cartTotal() {
                return this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            },

            increaseQuantity(id) {
                const item = this.cart.find(item => item.id === id);
                if (item) {
                    item.quantity++;
                    CartStorage.save(this.cart);
                }
            },

            decreaseQuantity(id) {
                const item = this.cart.find(item => item.id === id);
                if (item && item.quantity > 1) {
                    item.quantity--;
                    CartStorage.save(this.cart);
                } else if (item && item.quantity === 1) {
                    this.removeFromCart(id);
                }
            },

            removeFromCart(id) {
                this.cart = this.cart.filter(item => item.id !== id);
                CartStorage.save(this.cart);
            }
        }
    }
</script>
