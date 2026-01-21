@extends('layouts.app')

@section('title', 'Membership - The Lighthouse Cafe')

@section('content')
<!-- Hero -->
<div class="relative h-96 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=1920&h=600&fit=crop');">
    <div class="absolute inset-0 bg-linear-to-r from-black/80 to-black/40"></div>
    <div class="relative h-full flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white">
            <h1 class="text-5xl md:text-6xl font-serif font-bold mb-4">Exclusive Membership</h1>
            <p class="text-xl text-gray-200">Join the elite circle of culinary connoisseurs</p>
        </div>
    </div>
</div>

<!-- Membership Tiers -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="section-title">Choose Your Tier</h2>
            <p class="section-subtitle">Unlock exclusive benefits and unforgettable experiences</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Bronze -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-2xl transition transform hover:-translate-y-2">
                <div class="text-center mb-6">
                    <div class="w-20 h-20 bg-linear-to-br from-orange-400 to-orange-600 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <span class="text-3xl">🥉</span>
                    </div>
                    <h3 class="text-2xl font-serif font-bold mb-2">Bronze</h3>
                    <p class="text-4xl font-bold text-gray-900 mb-2">$99<span class="text-lg text-gray-500">/year</span></p>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-700">5% discount on all orders</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-700">Birthday dessert on us</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-700">Monthly newsletter</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-700">Priority waitlist</span>
                    </li>
                </ul>
                <button onclick="openMembershipModal('bronze')" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-lg transition">
                    Select Bronze
                </button>
            </div>

            <!-- Silver -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-2xl transition transform hover:-translate-y-2">
                <div class="text-center mb-6">
                    <div class="w-20 h-20 bg-linear-to-br from-gray-300 to-gray-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <span class="text-3xl">🥈</span>
                    </div>
                    <h3 class="text-2xl font-serif font-bold mb-2">Silver</h3>
                    <p class="text-4xl font-bold text-gray-900 mb-2">$199<span class="text-lg text-gray-500">/year</span></p>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-700">All Bronze benefits</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-700">10% discount on all orders</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-700">Complimentary appetizer monthly</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-700">Chef's table experience (2x/year)</span>
                    </li>
                </ul>
                <button onclick="openMembershipModal('silver')" class="w-full bg-gray-500 hover:bg-gray-600 text-white font-semibold py-3 rounded-lg transition">
                    Select Silver
                </button>
            </div>

            <!-- Gold -->
            <div class="bg-linear-to-br from-gold-400 to-gold-600 rounded-2xl shadow-2xl p-8 transform scale-105 relative">
                <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-red-500 text-black px-4 py-1 rounded-full text-sm font-bold">
                    MOST POPULAR
                </div>
                <div class="text-center mb-6">
                    <div class="w-20 h-20 bg-white rounded-full mx-auto mb-4 flex items-center justify-center">
                        <span class="text-3xl">🥇</span>
                    </div>
                    <h3 class="text-2xl font-serif font-bold mb-2 text-white">Gold</h3>
                    <p class="text-4xl font-bold text-black mb-2">$399<span class="text-lg text-yellow-100">/year</span></p>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-black mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-black font-medium">All Silver benefits</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-black mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-black font-medium">All Silver benefits</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-black mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-black font-medium">Private dining events access</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-black mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-black font-medium">Wine tasting sessions (4x/year)</span>
                    </li>
                </ul>
                <button onclick="openMembershipModal('gold')" class="w-full bg-white hover:bg-gray-100 text-gold-600 font-bold py-3 rounded-lg transition shadow-lg">
                    Select Gold
                </button>
            </div>

            <!-- Platinum -->
            <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-2xl transition transform hover:-translate-y-2 border-2 border-primary-600">
                <div class="text-center mb-6">
                    <div class="w-20 h-20 bg-linear-to-br from-primary-500 to-primary-700 rounded-full mx-auto mb-4 flex items-center justify-center">
                        <span class="text-3xl">💎</span>
                    </div>
                    <h3 class="text-2xl font-serif font-bold mb-2">Platinum</h3>
                    <p class="text-4xl font-bold text-gray-900 mb-2">$799<span class="text-lg text-gray-500">/year</span></p>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-700">All Gold benefits</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-700">20% discount on all orders</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-700">Unlimited chef's table</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-700">Personal concierge service</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-700">Annual culinary trip</span>
                    </li>
                </ul>
                <button onclick="openMembershipModal('platinum')" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 rounded-lg transition">
                    Select Platinum
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Membership Form Modal -->
<div id="membershipModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4" onclick="if(event.target === this) closeMembershipModal()">
    <div class="bg-white rounded-2xl max-w-md w-full p-8" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-serif font-bold">Join Now</h2>
            <button onclick="closeMembershipModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('membership.register') }}" method="POST">
            @csrf
            <input type="hidden" name="membership_tier" id="selectedTier">
            
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Full Name</label>
                <input type="text" name="name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" name="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Phone</label>
                <input type="tel" name="phone" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500">
            </div>

            <button type="submit" class="w-full btn-primary">
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