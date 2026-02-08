@extends('layouts.app')

@section('title', 'Reservations - The Lighthouse Cafe')

@section('content')
    <!-- Hero -->
    <div class="relative h-80 bg-cover bg-center"
        style="background-image: url('https://images.unsplash.com/photo-1530554764233-e79e16c91d08?w=1920&h=600&fit=crop');">
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="relative h-full flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white">
                <h1 class="text-5xl md:text-6xl font-serif font-bold mb-4">Reserve Your Table</h1>
                <p class="text-xl text-gray-200">An unforgettable dining experience awaits</p>
            </div>
        </div>
    </div>

    <!-- Reservation Form -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-2xl p-8 md:p-12">
                <div class="text-center mb-12 ">
                    <h2 class="text-4xl font-serif font-bold text-gray-900 mb-4">Book Your Experience</h2>
                    <p class="text-gray-600">Please fill out the form below and we'll confirm your reservation within 24
                        hours</p>
                </div>

                <form action="{{ route('reservations.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Full Name *</label>
                            <input type="text" name="name" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition"
                                placeholder="Sujal Lamichhane">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Email Address *</label>
                            <input type="email" name="email" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition"
                                placeholder="sujal@example.com">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Phone Number *</label>
                            <input type="tel" name="phone" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition"
                                placeholder="(555) 123-4567">
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Number of Guests *</label>
                            <select name="guests" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition">
                                <option value="">Select guests</option>
                                @for ($i = 1; $i <= 20; $i++)
                                    <option value="{{ $i }}">{{ $i }}
                                        {{ $i == 1 ? 'Guest' : 'Guests' }}</option>
                                @endfor
                            </select>
                            @error('guests')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Reservation Date *</label>
                            <input type="date" name="date" required min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition">
                            @error('date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-700 font-semibold mb-2">Preferred Time *</label>
                            <select name="time" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition">
                                <option value="">Select time</option>
                                <option value="06:00">6:00 AM</option>
                                <option value="06:30">6:30 AM</option>
                                <option value="07:00">7:00 AM</option>
                                <option value="07:30">7:30 AM</option>
                                <option value="08:00">8:00 AM</option>
                                <option value="08:30">8:30 AM</option>
                                <option value="09:00">9:00 AM</option>
                                <option value="09:30">9:30 AM</option>
                                <option value="10:00">10:00 AM</option>
                                <option value="10:30">10:30 AM</option>
                                <option value="11:00">11:00 AM</option>
                                <option value="11:30">11:30 AM</option>
                                <option value="12:00">12:00 PM</option>
                                <option value="19:30">12:30 PM</option>
                                <option value="20:00">1:00 PM</option>
                                <option value="20:30">1:30 PM</option>
                                <option value="21:00">2:00 PM</option>
                            </select>
                            @error('time')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Special Requests (Optional)</label>
                        <textarea name="special_requests" rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition"
                            placeholder="Dietary restrictions, special occasions, seating preferences, etc."></textarea>
                    </div>

                    <div class="bg-primary-50 border border-primary-200 rounded-lg p-4">
                        <p class="text-sm text-gray-700">
                            <strong>Please note:</strong> Reservations are subject to availability. We will confirm your
                            booking via email within 24 hours. For same-day reservations, please call us at (781) 391-0009.
                        </p>
                    </div>

                    <button type="submit"
                        class="w-full btn-primary text-lg py-4 bg-amber-200 hover:bg-amber-400 rounded-lg font-semibold transition">
                        Submit Reservation Request
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Info Cards -->
    <section class="py-16 bg-blue-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    class="text-center p-6 bg-amber-300 rounded-xl shadow-lg hover:bg-amber-400 transition-transform hover:scale-105">
                    <div class="w-16 h-16 bg-blue-400 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-serif font-bold mb-2">Operating Hours</h3>
                    <p class="text-gray-600">Mon-Thu: 6am - 2pm<br>Fri-Sat: 6am - 2pm<br>Sun: 6am - 2pm</p>
                </div>

                <div
                    class="text-center p-6 bg-amber-300 rounded-xl shadow-lg hover:bg-amber-400 transition-transform hover:scale-105">
                    <div class="w-16 h-16 bg-blue-400 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-serif font-bold mb-2">Location</h3>
                    <p class="text-gray-600">20 High ST<br>Medford, MA 02155</p>
                </div>

                <div
                    class="text-center p-6 bg-amber-300 rounded-xl shadow-lg hover:bg-amber-400 transition-transform hover:scale-105">
                    <div class="w-16 h-16 bg-blue-400 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-serif font-bold mb-2">Contact</h3>
                    <p class="text-gray-600">(781) 391-0009<br>info@lighthousecafe.com</p>
                </div>
            </div>
        </div>
    </section>
@endsection
