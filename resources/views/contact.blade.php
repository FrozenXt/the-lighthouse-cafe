@extends('layouts.app')

@section('title', 'Contact Us - The Lighthouse Cafe')

@section('content')
    <!-- Hero Section -->
    <div class="relative h-80 bg-cover bg-center overflow-hidden"
        style="background-image: url('https://images.unsplash.com/photo-1516594798853-1e85b6f62f51?w=1920&h=400&fit=crop');">
        <div class="absolute inset-0 bg-linear-to-br from-black/60 via-teal-900/50 to-blue-900/60"></div>
        <div class="absolute inset-0 bg-linear-to-t from-black/40 to-transparent"></div>
        <div class="relative h-full flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white text-center w-full">
                <h1 class="text-5xl md:text-6xl font-serif font-extrabold mb-4 drop-shadow-2xl">Get In Touch</h1>
                <p class="text-xl md:text-2xl text-gray-100 drop-shadow-lg">We'd love to hear from you!</p>
            </div>
        </div>
    </div>

    <div class="bg-white">
        <!-- Success Message -->
        @if (session('success'))
            <div class="bg-linear-to-r from-green-50 to-emerald-50 border-l-4 border-green-500">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    <div class="flex items-center gap-4">
                        <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <p class="text-green-800 font-semibold">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Contact Info & Form Section -->
        <section class="py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    <!-- Contact Information -->
                    <div class="lg:col-span-1 space-y-8">
                        <h2 class="text-3xl font-serif font-bold text-slate-800 mb-8">Contact Information</h2>

                        <!-- Location -->
                        <div class="bg-linear-to-br from-teal-50 to-blue-50 rounded-xl p-8 border border-teal-200">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 bg-teal-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-slate-800 mb-2">Location</h3>
                                    <p class="text-slate-600 font-semibold">The Lighthouse Cafe</p>
                                    <p class="text-slate-600">20 High Street</p>
                                    <p class="text-slate-600">Medford, MA 02155, USA</p>
                                </div>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="bg-linear-to-br from-amber-50 to-orange-50 rounded-xl p-8 border border-amber-200">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 bg-amber-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773c.537 1.477 1.472 2.783 2.653 3.72l.773-1.548a1 1 0 011.06-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-slate-800 mb-2">Phone</h3>
                                    <p class="text-slate-600 font-semibold text-lg">(617) 395-8200</p>
                                    <p class="text-slate-600 text-sm mt-2">Mon-Sun: 11:00 AM - 10:00 PM</p>
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="bg-linear-to-br from-blue-50 to-indigo-50 rounded-xl p-8 border border-blue-200">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-slate-800 mb-2">Email</h3>
                                    <p class="text-slate-600 font-semibold">info@lighthousecafe.com</p>
                                    <p class="text-slate-600 text-sm mt-2">For reservations:</p>
                                    <p class="text-slate-600 font-semibold">reserve@lighthousecafe.com</p>
                                </div>
                            </div>
                        </div>

                        <!-- Hours -->
                        <div class="bg-linear-to-br from-pink-50 to-red-50 rounded-xl p-8 border border-pink-200">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 bg-pink-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00-.293.707l-2.828 2.829a1 1 0 101.415 1.415L9 10.586V6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-slate-800 mb-3">Hours</h3>
                                    <div class="space-y-1 text-slate-600 text-sm">
                                        <p><span class="font-semibold">Monday - Sunday:</span></p>
                                        <p>11:00 AM - 10:00 PM</p>
                                        <p class="pt-2 italic">Closed on major holidays</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-xl shadow-xl p-10 border border-slate-200">
                            <h2 class="text-3xl font-serif font-bold text-slate-800 mb-8">Send us a Message</h2>

                            @if ($errors->any())
                                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                                    <p class="text-red-800 font-semibold mb-2">Please fix the following errors:</p>
                                    <ul class="text-red-700 text-sm space-y-1 list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                                @csrf

                                <!-- Name Field -->
                                <div>
                                    <label for="name" class="block text-slate-700 font-bold mb-2">Full Name *</label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-200 @error('name') border-red-500 @enderror"
                                        placeholder="John Doe">
                                    @error('name')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email Field -->
                                <div>
                                    <label for="email" class="block text-slate-700 font-bold mb-2">Email Address
                                        *</label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-200 @error('email') border-red-500 @enderror"
                                        placeholder="john@example.com">
                                    @error('email')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Phone Field -->
                                <div>
                                    <label for="phone" class="block text-slate-700 font-bold mb-2">Phone Number</label>
                                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-200"
                                        placeholder="(617) 000-0000">
                                </div>

                                <!-- Subject Field -->
                                <div>
                                    <label for="subject" class="block text-slate-700 font-bold mb-2">Subject *</label>
                                    <input type="text" id="subject" name="subject" value="{{ old('subject') }}"
                                        required
                                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-200 @error('subject') border-red-500 @enderror"
                                        placeholder="How can we help?">
                                    @error('subject')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Message Field -->
                                <div>
                                    <label for="message" class="block text-slate-700 font-bold mb-2">Message *</label>
                                    <textarea id="message" name="message" rows="6" required
                                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-teal-500 focus:ring-2 focus:ring-teal-200 resize-none @error('message') border-red-500 @enderror"
                                        placeholder="Tell us what's on your mind...">{{ old('message') }}</textarea>
                                    @error('message')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <button type="submit"
                                    class="w-full bg-linear-to-r from-teal-500 to-blue-600 hover:from-teal-600 hover:to-blue-700 text-white font-bold py-4 rounded-lg transition duration-300 transform hover:scale-105 shadow-lg">
                                    Send Message
                                </button>

                                <p class="text-sm text-slate-500 text-center">
                                    We'll get back to you as soon as possible. Thank you for reaching out!
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Map Section -->
        <section class="py-12 bg-slate-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-serif font-bold text-slate-800 text-center mb-12">Find Us on the Map</h2>
                <div class="rounded-xl overflow-hidden shadow-2xl h-96">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2953.8217839752156!2d-71.10654!3d42.41226!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89e3736dd8e8c4f9%3A0x1234567890ab!2s20%20High%20St%2C%20Medford%2C%20MA%2002155!5e0!3m2!1sen!2sus!4v1234567890"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </section>
    </div>
@endsection
