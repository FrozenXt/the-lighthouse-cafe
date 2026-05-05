@extends('layouts.app')

@section('title', 'Membership - The Lighthouse Cafe')

@section('content')
    <!-- Hero Section -->
    <div class="relative h-screen bg-cover bg-center overflow-hidden"
        style="background-image: url('https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=1920&h=800&fit=crop');">
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/50 to-black/70"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-amber-900/30 to-transparent"></div>
        <div class="relative h-full flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white w-full">
                <div class="max-w-2xl">
                    <p class="text-amber-400 font-semibold text-lg mb-4 uppercase tracking-widest">Join Our Exclusive
                        Community</p>
                    <h1 class="text-6xl md:text-7xl font-serif font-bold mb-6 leading-tight">Become a Lighthouse Member</h1>
                    <p class="text-xl text-gray-100 mb-2">Experience world-class dining privileges and unforgettable culinary
                        moments</p>
                    <p class="text-lg text-amber-200 mb-8">Exclusive discounts, private events, and personalized service
                        await</p>
                    <a href="#membership-tiers"
                        class="inline-block bg-amber-500 hover:bg-amber-600 text-white font-bold py-4 px-8 rounded-lg transition transform hover:scale-105 shadow-lg">
                        Explore Membership Tiers
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Why Join Section -->
    <section class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-serif font-bold text-slate-800 mb-4">Why Join The Lighthouse Circle?</h2>
                <p class="text-lg text-slate-600">Exclusive privileges designed for our most valued guests</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white rounded-xl shadow-md p-8 text-center hover:shadow-lg transition">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-amber-400 to-amber-600 rounded-full mx-auto mb-4 flex items-center justify-center text-2xl">
                        🎁</div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Premium Discounts</h3>
                    <p class="text-slate-600">Save up to 20% on every order plus exclusive monthly specials</p>
                </div>
                <div class="bg-white rounded-xl shadow-md p-8 text-center hover:shadow-lg transition">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-amber-400 to-amber-600 rounded-full mx-auto mb-4 flex items-center justify-center text-2xl">
                        👨‍🍳</div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Chef's Table Access</h3>
                    <p class="text-slate-600">Experience intimate dining with our culinary team</p>
                </div>
                <div class="bg-white rounded-xl shadow-md p-8 text-center hover:shadow-lg transition">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-amber-400 to-amber-600 rounded-full mx-auto mb-4 flex items-center justify-center text-2xl">
                        🍷</div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Wine Tastings</h3>
                    <p class="text-slate-600">Curated wine pairing sessions with expert sommeliers</p>
                </div>
                <div class="bg-white rounded-xl shadow-md p-8 text-center hover:shadow-lg transition">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-amber-400 to-amber-600 rounded-full mx-auto mb-4 flex items-center justify-center text-2xl">
                        🎉</div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Private Events</h3>
                    <p class="text-slate-600">First access to exclusive member gatherings and celebrations</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Membership Tiers -->
    <section id="membership-tiers" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-serif font-bold text-slate-800 mb-4">Membership Tiers</h2>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto">Each tier unlocks a new level of culinary excellence.
                    Select the package that best matches your dining lifestyle.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-16">
                <!-- Bronze -->
                <div
                    class="bg-white rounded-2xl border-2 border-gray-200 overflow-hidden hover:shadow-2xl transition-all duration-300">
                    <div class="bg-gradient-to-r from-orange-400 to-orange-500 p-8 text-white">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-3xl font-serif font-bold">Bronze</h3>
                            <span class="text-4xl">🥉</span>
                        </div>
                        <p class="text-orange-100 text-sm mb-4">Perfect for casual diners</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-4xl font-bold">$99</span>
                            <span class="text-orange-100">/year</span>
                        </div>
                    </div>
                    <div class="p-8">
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-700">5% discount on all orders</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-700">Birthday dessert on us</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-700">Monthly newsletter</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-700">Priority reservation line</span>
                            </li>
                        </ul>
                        <button onclick="openMembershipModal('bronze')"
                            class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-lg transition">
                            Join Bronze
                        </button>
                    </div>
                </div>

                <!-- Silver -->
                <div
                    class="bg-white rounded-2xl border-2 border-gray-200 overflow-hidden hover:shadow-2xl transition-all duration-300">
                    <div class="bg-gradient-to-r from-gray-400 to-gray-500 p-8 text-white">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-3xl font-serif font-bold">Silver</h3>
                            <span class="text-4xl">🥈</span>
                        </div>
                        <p class="text-gray-100 text-sm mb-4">For the dining enthusiast</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-4xl font-bold">$199</span>
                            <span class="text-gray-100">/year</span>
                        </div>
                    </div>
                    <div class="p-8">
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-700">All Bronze benefits +</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-700">10% discount on all orders</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-700">Complimentary appetizer monthly</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-700">Chef's table (2x/year)</span>
                            </li>
                        </ul>
                        <button onclick="openMembershipModal('silver')"
                            class="w-full bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 rounded-lg transition">
                            Join Silver
                        </button>
                    </div>
                </div>

                <!-- Gold (Most Popular) -->
                <div
                    class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-2xl border-3 border-amber-500 overflow-hidden hover:shadow-2xl transition-all duration-300 transform lg:scale-105 relative">
                    <div
                        class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-gradient-to-r from-amber-500 to-amber-600 text-white px-6 py-2 rounded-full font-bold text-sm shadow-lg">
                        MOST POPULAR
                    </div>
                    <div class="bg-gradient-to-r from-amber-500 to-amber-600 p-8 text-white">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-3xl font-serif font-bold">Gold</h3>
                            <span class="text-4xl">🥇</span>
                        </div>
                        <p class="text-amber-100 text-sm mb-4">Premium member status</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-4xl font-bold">$399</span>
                            <span class="text-amber-100">/year</span>
                        </div>
                    </div>
                    <div class="p-8">
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-amber-600 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-800 font-medium">All Silver benefits +</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-amber-600 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-800 font-medium">15% discount on all orders</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-amber-600 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-800 font-medium">Private dining events access</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-amber-600 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-800 font-medium">Wine tasting sessions (4x/year)</span>
                            </li>
                        </ul>
                        <button onclick="openMembershipModal('gold')"
                            class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 rounded-lg transition shadow-lg">
                            Join Gold
                        </button>
                    </div>
                </div>

                <!-- Platinum -->
                <div
                    class="bg-white rounded-2xl border-2 border-purple-300 overflow-hidden hover:shadow-2xl transition-all duration-300">
                    <div class="bg-gradient-to-r from-purple-600 to-purple-700 p-8 text-white">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-3xl font-serif font-bold">Platinum</h3>
                            <span class="text-4xl">💎</span>
                        </div>
                        <p class="text-purple-100 text-sm mb-4">Elite VIP experience</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-4xl font-bold">$799</span>
                            <span class="text-purple-100">/year</span>
                        </div>
                    </div>
                    <div class="p-8">
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-purple-600 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-700">All Gold benefits +</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-purple-600 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-700">20% discount on all orders</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-purple-600 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-700">Unlimited chef's table access</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-purple-600 flex-shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span class="text-gray-700">Personal concierge service</span>
                            </li>
                        </ul>
                        <button onclick="openMembershipModal('platinum')"
                            class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 rounded-lg transition">
                            Join Platinum
                        </button>
                    </div>
                </div>
            </div>

            <!-- Comparison Table -->
            <div class="mt-20">
                <h3 class="text-3xl font-serif font-bold text-slate-800 mb-8 text-center">Feature Comparison</h3>
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="w-full bg-white">
                        <thead class="bg-slate-100 border-b-2 border-slate-300">
                            <tr>
                                <th class="px-6 py-4 text-left font-semibold text-slate-800">Feature</th>
                                <th class="px-6 py-4 text-center font-semibold text-slate-800">Bronze</th>
                                <th class="px-6 py-4 text-center font-semibold text-slate-800">Silver</th>
                                <th class="px-6 py-4 text-center font-semibold text-orange-600 bg-orange-50">Gold</th>
                                <th class="px-6 py-4 text-center font-semibold text-slate-800">Platinum</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-medium text-slate-700">Dining Discount</td>
                                <td class="px-6 py-4 text-center text-slate-600">5%</td>
                                <td class="px-6 py-4 text-center text-slate-600">10%</td>
                                <td class="px-6 py-4 text-center font-bold text-orange-600 bg-orange-50">15%</td>
                                <td class="px-6 py-4 text-center font-bold text-slate-800">20%</td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-medium text-slate-700">Birthday Dessert</td>
                                <td class="px-6 py-4 text-center text-green-600 font-semibold">✓</td>
                                <td class="px-6 py-4 text-center text-green-600 font-semibold">✓</td>
                                <td class="px-6 py-4 text-center bg-orange-50 text-green-600 font-semibold">✓</td>
                                <td class="px-6 py-4 text-center text-green-600 font-semibold">✓</td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-medium text-slate-700">Chef's Table Access</td>
                                <td class="px-6 py-4 text-center text-gray-400">—</td>
                                <td class="px-6 py-4 text-center text-slate-600">2x/year</td>
                                <td class="px-6 py-4 text-center font-semibold text-orange-600 bg-orange-50">4x/year</td>
                                <td class="px-6 py-4 text-center font-semibold text-slate-800">Unlimited</td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-medium text-slate-700">Private Dining Events</td>
                                <td class="px-6 py-4 text-center text-gray-400">—</td>
                                <td class="px-6 py-4 text-center text-gray-400">—</td>
                                <td class="px-6 py-4 text-center bg-orange-50 text-green-600 font-semibold">✓</td>
                                <td class="px-6 py-4 text-center text-green-600 font-semibold">✓ VIP</td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-medium text-slate-700">Wine Tastings</td>
                                <td class="px-6 py-4 text-center text-gray-400">—</td>
                                <td class="px-6 py-4 text-center text-gray-400">—</td>
                                <td class="px-6 py-4 text-center bg-orange-50">4x/year</td>
                                <td class="px-6 py-4 text-center font-semibold">Monthly</td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-medium text-slate-700">Concierge Service</td>
                                <td class="px-6 py-4 text-center text-gray-400">—</td>
                                <td class="px-6 py-4 text-center text-gray-400">—</td>
                                <td class="px-6 py-4 text-center bg-orange-50 text-gray-400">—</td>
                                <td class="px-6 py-4 text-center text-green-600 font-semibold">✓ Personal</td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-medium text-slate-700">Complimentary Items</td>
                                <td class="px-6 py-4 text-center text-gray-400">—</td>
                                <td class="px-6 py-4 text-center text-slate-600">Appetizer/mo</td>
                                <td class="px-6 py-4 text-center bg-orange-50 font-semibold">Entree/mo</td>
                                <td class="px-6 py-4 text-center font-semibold">Premium/mo</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Member Testimonials Section -->
    <section class="py-20 bg-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-serif font-bold text-slate-800 mb-4">What Our Members Say</h2>
                <p class="text-lg text-slate-600">Join hundreds of satisfied diners who enjoy exclusive benefits</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl p-8 shadow-md">
                    <div class="flex gap-1 mb-4">
                        <span class="text-amber-400">★</span>
                        <span class="text-amber-400">★</span>
                        <span class="text-amber-400">★</span>
                        <span class="text-amber-400">★</span>
                        <span class="text-amber-400">★</span>
                    </div>
                    <p class="text-gray-700 mb-4 italic">"The chef's table experience was absolutely unforgettable. The
                        personal attention and delicious cuisine made our anniversary dinner truly special."</p>
                    <p class="font-semibold text-slate-800">Sarah Mitchell</p>
                    <p class="text-sm text-slate-600">Gold Member</p>
                </div>

                <div class="bg-white rounded-xl p-8 shadow-md">
                    <div class="flex gap-1 mb-4">
                        <span class="text-amber-400">★</span>
                        <span class="text-amber-400">★</span>
                        <span class="text-amber-400">★</span>
                        <span class="text-amber-400">★</span>
                        <span class="text-amber-400">★</span>
                    </div>
                    <p class="text-gray-700 mb-4 italic">"As a Platinum member, the personalized concierge service is
                        exceptional. They remember all my preferences and always go above and beyond."</p>
                    <p class="font-semibold text-slate-800">James Rodriguez</p>
                    <p class="text-sm text-slate-600">Platinum Member</p>
                </div>

                <div class="bg-white rounded-xl p-8 shadow-md">
                    <div class="flex gap-1 mb-4">
                        <span class="text-amber-400">★</span>
                        <span class="text-amber-400">★</span>
                        <span class="text-amber-400">★</span>
                        <span class="text-amber-400">★</span>
                        <span class="text-amber-400">★</span>
                    </div>
                    <p class="text-gray-700 mb-4 italic">"The wine tasting sessions have really enhanced my appreciation
                        for fine wines. Worth every penny and more!"</p>
                    <p class="font-semibold text-slate-800">Emily Chen</p>
                    <p class="text-sm text-slate-600">Silver Member</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-serif font-bold text-slate-800 mb-4">How It Works</h2>
                <p class="text-lg text-slate-600">Getting started is easy. Three simple steps to exclusive benefits.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-amber-400 to-amber-600 rounded-full mx-auto mb-6 flex items-center justify-center text-white text-2xl font-bold">
                        1</div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-4">Choose Your Tier</h3>
                    <p class="text-gray-700">Select the membership level that best fits your dining habits and preferences.
                    </p>
                </div>

                <div class="text-center">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-amber-400 to-amber-600 rounded-full mx-auto mb-6 flex items-center justify-center text-white text-2xl font-bold">
                        2</div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-4">Complete Registration</h3>
                    <p class="text-gray-700">Fill out a quick form with your contact information and payment details. Takes
                        less than 5 minutes.</p>
                </div>

                <div class="text-center">
                    <div
                        class="w-16 h-16 bg-gradient-to-br from-amber-400 to-amber-600 rounded-full mx-auto mb-6 flex items-center justify-center text-white text-2xl font-bold">
                        3</div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-4">Start Enjoying Benefits</h3>
                    <p class="text-gray-700">Your membership is active immediately! Start enjoying discounts and exclusive
                        perks right away.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-amber-500 to-amber-600">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-serif font-bold text-white mb-6">Ready to Become a Member?</h2>
            <p class="text-xl text-amber-100 mb-8">Join The Lighthouse Cafe family and start enjoying exclusive dining
                privileges today.</p>
            <a href="#membership-tiers"
                class="inline-block bg-white text-amber-600 font-bold py-4 px-8 rounded-lg transition transform hover:scale-105 shadow-lg hover:shadow-xl">
                View All Tiers
            </a>
        </div>
    </section>

    <!-- Membership Form Modal -->
    <div id="membershipModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4"
        onclick="if(event.target === this) closeMembershipModal()">
        <div class="bg-white rounded-2xl max-w-md w-full p-8" onclick="event.stopPropagation()">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-serif font-bold">Join Now</h2>
                <button onclick="closeMembershipModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form action="{{ route('membership.register') }}" method="POST">
                @csrf
                <input type="hidden" name="membership_tier" id="selectedTier">

                <div class="mb-4">
                    <label class="block text-slate-700 font-semibold mb-2">Full Name *</label>
                    <input type="text" name="name" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition">
                </div>

                <div class="mb-4">
                    <label class="block text-slate-700 font-semibold mb-2">Email *</label>
                    <input type="email" name="email" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition">
                </div>

                <div class="mb-6">
                    <label class="block text-slate-700 font-semibold mb-2">Phone *</label>
                    <input type="tel" name="phone" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition">
                </div>

                <button type="submit"
                    class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 rounded-lg transition">
                    Complete Registration
                </button>
            </form>
        </div>
    </div>

    <script>
        function openMembershipModal(tier) {
            document.getElementById('selectedTier').value = tier;
            document.getElementById('membershipModal').classList.remove('hidden');
            document.getElementById('membershipModal').classList.add('flex');
        }

        function closeMembershipModal() {
            document.getElementById('membershipModal').classList.add('hidden');
            document.getElementById('membershipModal').classList.remove('flex');
        }
    </script>
@endsection
