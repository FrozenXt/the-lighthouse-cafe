@extends('layouts.app')

@section('title', 'About Us - The Lighthouse Cafe')

@section('content')
    <!-- Hero Section -->
    <div class="relative h-96 bg-cover bg-center overflow-hidden"
        style="background-image: url('https://images.unsplash.com/photo-1552168324-d612d080c3fd?w=1920&h=400&fit=crop');">
        <div class="absolute inset-0 bg-linear-to-br from-black/60 via-teal-900/50 to-blue-900/60"></div>
        <div class="absolute inset-0 bg-linear-to-t from-black/40 to-transparent"></div>
        <div class="relative h-full flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white text-center w-full">
                <h1 class="text-5xl md:text-6xl font-serif font-extrabold mb-4 drop-shadow-2xl">About The Lighthouse Cafe
                </h1>
                <p class="text-xl md:text-2xl text-gray-100 drop-shadow-lg">Where culinary excellence meets warm hospitality
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-white">
        <!-- Story Section -->
        <section class="py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-4xl font-serif font-bold text-slate-800 mb-6">Our Story</h2>
                        <p class="text-lg text-slate-600 mb-4 leading-relaxed">
                            The Lighthouse Cafe was founded with a simple mission: to create a sanctuary where exceptional
                            food meets genuine hospitality. Our name reflects our commitment to being a guiding light in the
                            culinary world, illuminating the path to unforgettable dining experiences.
                        </p>
                        <p class="text-lg text-slate-600 mb-4 leading-relaxed">
                            Located in the heart of Medford, Massachusetts, we've built a community around our belief that
                            great food brings people together. Every dish is crafted with passion, using the finest
                            ingredients sourced from local suppliers whenever possible.
                        </p>
                        <p class="text-lg text-slate-600 leading-relaxed">
                            From our signature seafood specialties to our perfectly seared steaks and delicate desserts,
                            each plate tells a story of dedication to the culinary arts.
                        </p>
                    </div>
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1495521821757-a1efb6729352?w=600&h=500&fit=crop"
                            alt="The Lighthouse Cafe Interior" class="rounded-xl shadow-2xl">
                        <div
                            class="absolute -bottom-6 -right-6 bg-linear-to-br from-yellow-400 to-orange-500 rounded-xl p-8 text-white shadow-xl">
                            <p class="text-5xl font-bold">10+</p>
                            <p class="text-sm font-semibold">Years of Excellence</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Values Section -->
        <section class="py-24 bg-linear-to-br from-slate-50 to-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-4xl font-serif font-bold text-slate-800 text-center mb-16">Our Core Values</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    <!-- Quality -->
                    <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition duration-300">
                        <div
                            class="w-16 h-16 bg-linear-to-br from-teal-500 to-blue-600 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800 mb-3">Quality First</h3>
                        <p class="text-slate-600 leading-relaxed">
                            We believe that excellence is not an act, but a habit. Every ingredient, every technique, and
                            every presentation reflects our unwavering commitment to quality.
                        </p>
                    </div>

                    <!-- Community -->
                    <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition duration-300">
                        <div
                            class="w-16 h-16 bg-linear-to-br from-amber-500 to-orange-600 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v2h8v-2zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-2a4 4 0 00-8 0v2h8z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800 mb-3">Community Focused</h3>
                        <p class="text-slate-600 leading-relaxed">
                            We're not just a restaurant; we're a gathering place. Building relationships with our guests and
                            supporting the Medford community is central to who we are.
                        </p>
                    </div>

                    <!-- Innovation -->
                    <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition duration-300">
                        <div
                            class="w-16 h-16 bg-linear-to-br from-pink-500 to-red-600 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800 mb-3">Innovation & Tradition</h3>
                        <p class="text-slate-600 leading-relaxed">
                            We honor culinary traditions while embracing creativity and innovation. This balance keeps our
                            menu fresh, exciting, and always rooted in excellence.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Location Section -->
        <section class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-4xl font-serif font-bold text-slate-800 mb-8">Visit Us</h2>
                        <div class="bg-linear-to-br from-slate-50 to-gray-100 rounded-xl p-8 space-y-6">
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
                                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Address</p>
                                    <p class="text-lg font-semibold text-slate-800">The Lighthouse Cafe</p>
                                    <p class="text-slate-600">20 High Street</p>
                                    <p class="text-slate-600">Medford, MA 02155, USA</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 bg-amber-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773c.537 1.477 1.472 2.783 2.653 3.72l.773-1.548a1 1 0 011.06-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Phone</p>
                                    <p class="text-lg font-semibold text-slate-800">(617) 395-8200</p>
                                    <p class="text-slate-600 text-sm mt-1">Mon-Sun: 11:00 AM - 10:00 PM</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Email</p>
                                    <p class="text-lg font-semibold text-slate-800">info@lighthousecafe.com</p>
                                    <p class="text-slate-600 text-sm mt-1">Reservations: reserve@lighthousecafe.com</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl overflow-hidden shadow-2xl">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2953.8217839752156!2d-71.10654!3d42.41226!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89e3736dd8e8c4f9%3A0x1234567890ab!2s20%20High%20St%2C%20Medford%2C%20MA%2002155!5e0!3m2!1sen!2sus!4v1234567890"
                            width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section class="py-24 bg-linear-to-br from-slate-50 to-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-4xl font-serif font-bold text-slate-800 text-center mb-16">Meet Our Team</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    <!-- Chef -->
                    <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300">
                        <div class="h-64 bg-gradient-to-br from-teal-400 to-blue-500 flex items-center justify-center">
                            <svg class="w-32 h-32 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="p-6">
                            <h3 class="text-2xl font-bold text-slate-800 mb-1">Executive Chef</h3>
                            <p class="text-teal-600 font-semibold mb-3">Master Culinary Arts</p>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                With 15+ years of experience in fine dining, our chef brings passion and expertise to every
                                dish served at The Lighthouse Cafe.
                            </p>
                        </div>
                    </div>

                    <!-- Sommelier -->
                    <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300">
                        <div class="h-64 bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center">
                            <svg class="w-32 h-32 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="p-6">
                            <h3 class="text-2xl font-bold text-slate-800 mb-1">Wine Director</h3>
                            <p class="text-amber-600 font-semibold mb-3">Certified Sommelier</p>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                Our sommelier curates an exceptional wine collection that perfectly complements our diverse
                                culinary offerings.
                            </p>
                        </div>
                    </div>

                    <!-- Manager -->
                    <div class="bg-white rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition duration-300">
                        <div class="h-64 bg-gradient-to-br from-pink-400 to-red-500 flex items-center justify-center">
                            <svg class="w-32 h-32 text-white opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="p-6">
                            <h3 class="text-2xl font-bold text-slate-800 mb-1">General Manager</h3>
                            <p class="text-red-600 font-semibold mb-3">Hospitality Leader</p>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                Dedicated to ensuring every guest experiences warm hospitality and exceptional service from
                                the moment they arrive.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-16 bg-linear-to-r from-teal-600 to-blue-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-4xl font-serif font-bold text-white mb-6">Ready to Experience Excellence?</h2>
                <p class="text-xl text-gray-100 mb-8 max-w-2xl mx-auto">
                    Join us for an unforgettable culinary journey. Reserve your table today!
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('reservations.create') }}"
                        class="inline-block bg-white text-teal-600 hover:bg-gray-100 font-bold py-4 px-10 rounded-lg transition duration-300 transform hover:scale-105">
                        Make a Reservation
                    </a>
                    <a href="{{ route('menu') }}"
                        class="inline-block bg-teal-700 hover:bg-teal-800 text-white font-bold py-4 px-10 rounded-lg transition duration-300 transform hover:scale-105 border-2 border-white">
                        Explore Our Menu
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
