<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'The Lighthouse Cafe - Coastal Fine Dining')</title>
    @vite(['resources/css/app.css'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-slate-100">
    <!-- Navigation -->
    <nav x-data="{ open: false }"
        class="bg-gradient-to-r from-slate-800 via-slate-900 to-slate-800 shadow-2xl fixed w-full top-0 z-50 border-b border-amber-500/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                        <!-- IMAGE LOGO -->
                        <div
                            class="relative w-20 h-20 rounded-full overflow-hidden hover:scale-105 transition-transform">
                            <img src="{{ asset('images/lighthouselogo.png') }}" alt="The Lighthouse Cafe Logo"
                                class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h1
                                class="text-2xl font-serif font-bold text-amber-400 group-hover:text-amber-300 transition-colors">
                                The Lighthouse</h1>
                            <p class="text-xs text-slate-400 -mt-1 tracking-widest">CAFE</p>
                        </div>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}"
                        class="nav-link text-slate-200 hover:text-amber-400 font-medium transition-all duration-300">Home</a>
                    <a href="{{ route('menu') }}"
                        class="nav-link text-slate-200 hover:text-amber-400 font-medium transition-all duration-300">Menu</a>
                    <a href="{{ route('orders.index') }}"
                        class="nav-link text-slate-200 hover:text-amber-400 font-medium transition-all duration-300">Order
                        Online</a>
                    <a href="{{ route('reservations.create') }}"
                        class="nav-link text-slate-200 hover:text-amber-400 font-medium transition-all duration-300">Reservations</a>
                    <a href="{{ route('membership') }}"
                        class="nav-link text-slate-200 hover:text-amber-400 font-medium transition-all duration-300">Membership</a>
                    <a href="{{ route('about') }}"
                        class="nav-link text-slate-200 hover:text-amber-400 font-medium transition-all duration-300">About</a>
                    <a href="{{ route('contact') }}"
                        class="nav-link text-slate-200 hover:text-amber-400 font-medium transition-all duration-300">Contact</a>
                    <a href="{{ route('orders.index') }}" class="btn-primary">Order Now</a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button @click="open = !open" class="text-slate-200 hover:text-amber-400 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100" @click.away="open = false"
                class="md:hidden pb-4 bg-slate-800/50 backdrop-blur-lg rounded-lg mt-2 p-4">
                <a href="{{ route('home') }}"
                    class="block py-3 text-slate-200 hover:text-amber-400 hover:bg-slate-700/50 px-4 rounded transition-all">Home</a>
                <a href="{{ route('menu') }}"
                    class="block py-3 text-slate-200 hover:text-amber-400 hover:bg-slate-700/50 px-4 rounded transition-all">Menu</a>
                <a href="{{ route('orders.index') }}"
                    class="block py-3 text-slate-200 hover:text-amber-400 hover:bg-slate-700/50 px-4 rounded transition-all">Order
                    Online</a>
                <a href="{{ route('reservations.create') }}"
                    class="block py-3 text-slate-200 hover:text-amber-400 hover:bg-slate-700/50 px-4 rounded transition-all">Reservations</a>
                <a href="{{ route('membership') }}"
                    class="block py-3 text-slate-200 hover:text-amber-400 hover:bg-slate-700/50 px-4 rounded transition-all">Membership</a>
                <a href="{{ route('about') }}"
                    class="block py-3 text-slate-200 hover:text-amber-400 hover:bg-slate-700/50 px-4 rounded transition-all">About</a>
                <a href="{{ route('contact') }}"
                    class="block py-3 text-slate-200 hover:text-amber-400 hover:bg-slate-700/50 px-4 rounded transition-all">Contact</a>
            </div>
        </div>
    </nav>

    <!-- Success Message -->
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-x-full"
            x-transition:enter-end="opacity-100 transform translate-x-0"
            class="fixed top-24 right-4 z-50 bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-4 rounded-lg shadow-2xl border border-green-400/30">
            <div class="flex items-center space-x-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="pt-20">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer
        class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white mt-20 border-t-4 border-amber-500/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <!-- IMAGE LOGO IN FOOTER -->
                        <div class="relative w-12 h-12 rounded-full overflow-hidden">
                            <img src="{{ asset('images/lighthouselogo.png') }}" alt="The Lighthouse Cafe Logo"
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-2xl font-serif font-bold text-amber-400">The Lighthouse</h3>
                    </div>
                    <p class="text-slate-400 leading-relaxed">Coastal fine dining experience where elegance meets
                        flavor.</p>
                    <div class="flex space-x-4 mt-6">
                        <a href="#"
                            class="w-10 h-10 bg-slate-700 hover:bg-amber-500 rounded-full flex items-center justify-center transition-colors duration-300">
                            <span class="text-lg">📘</span>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-slate-700 hover:bg-amber-500 rounded-full flex items-center justify-center transition-colors duration-300">
                            <span class="text-lg">📷</span>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-slate-700 hover:bg-amber-500 rounded-full flex items-center justify-center transition-colors duration-300">
                            <span class="text-lg">🐦</span>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-4 text-amber-400">Quick Links</h4>
                    <ul class="space-y-3 text-slate-300">
                        <li><a href="{{ route('menu') }}"
                                class="hover:text-amber-400 transition-colors duration-300 flex items-center group">
                                <span class="mr-2 group-hover:mr-3 transition-all">→</span> Menu
                            </a></li>
                        <li><a href="{{ route('reservations.create') }}"
                                class="hover:text-amber-400 transition-colors duration-300 flex items-center group">
                                <span class="mr-2 group-hover:mr-3 transition-all">→</span> Reservations
                            </a></li>
                        <li><a href="{{ route('membership') }}"
                                class="hover:text-amber-400 transition-colors duration-300 flex items-center group">
                                <span class="mr-2 group-hover:mr-3 transition-all">→</span> Membership
                            </a></li>
                        <li><a href="{{ route('about') }}"
                                class="hover:text-amber-400 transition-colors duration-300 flex items-center group">
                                <span class="mr-2 group-hover:mr-3 transition-all">→</span> About Us
                            </a></li>
                        <li><a href="{{ route('contact') }}"
                                class="hover:text-amber-400 transition-colors duration-300 flex items-center group">
                                <span class="mr-2 group-hover:mr-3 transition-all">→</span> Contact
                            </a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-4 text-amber-400">Hours</h4>
                    <ul class="space-y-3 text-slate-300">
                        <li class="flex justify-between">
                            <span>Mon-Thu:</span>
                            <span class="text-amber-400 font-semibold">6am - 2pm</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Fri-Sat:</span>
                            <span class="text-amber-400 font-semibold">6am - 2pm</span>
                        </li>
                        <li class="flex justify-between">
                            <span>Sunday:</span>
                            <span class="text-amber-400 font-semibold">6am - 2pm</span>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-lg mb-4 text-amber-400">Contact</h4>
                    <ul class="space-y-3 text-slate-300">
                        <li class="flex items-start">
                            <span class="text-amber-400 mr-2">📍</span>
                            <span>20 High ST<br>Medford, MA 02155</span>
                        </li>
                        <li class="flex items-center">
                            <span class="text-amber-400 mr-2">📞</span>
                            <a href="tel:7813910009" class="hover:text-amber-400 transition-colors">(781) 391-0009</a>
                        </li>
                        <li class="flex items-center">
                            <span class="text-amber-400 mr-2">✉️</span>
                            <a href="mailto:info@lighthousecafe.com"
                                class="hover:text-amber-400 transition-colors">info@lighthousecafe.com</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-700 mt-12 pt-8 text-center">
                <p class="text-slate-400">&copy; 2025 The Lighthouse Cafe. All rights reserved.</p>
                <p class="text-slate-500 text-sm mt-2">Crafted with excellence and passion</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>
