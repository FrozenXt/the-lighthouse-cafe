<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'The Lighthouse Cafe - Coastal Fine Dining')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav x-data="{ open: false }" class="bg-white shadow-lg fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-linear-to-br from-primary-500 to-primary-700 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-serif font-bold text-gray-900">The Lighthouse</h1>
                            <p class="text-xs text-gray-500 -mt-1">CAFE</p>
                        </div>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-primary-600 font-medium transition">Home</a>
                    <a href="{{ route('menu') }}" class="text-gray-700 hover:text-primary-600 font-medium transition">Menu</a>
                    <a href="{{ route('reservations.create') }}" class="text-gray-700 hover:text-primary-600 font-medium transition">Reservations</a>
                    <a href="{{ route('membership') }}" class="text-gray-700 hover:text-primary-600 font-medium transition">Membership</a>
                    <a href="{{ route('about') }}" class="text-gray-700 hover:text-primary-600 font-medium transition">About</a>
                    <a href="{{ route('contact') }}" class="text-gray-700 hover:text-primary-600 font-medium transition">Contact</a>
                    <a href="{{ route('membership') }}" class="btn-primary">Become a Member</a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button @click="open = !open" class="text-gray-700 hover:text-primary-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="open" @click.away="open = false" class="md:hidden pb-4">
                <a href="{{ route('home') }}" class="block py-2 text-gray-700 hover:text-primary-600">Home</a>
                <a href="{{ route('menu') }}" class="block py-2 text-gray-700 hover:text-primary-600">Menu</a>
                <a href="{{ route('reservations.create') }}" class="block py-2 text-gray-700 hover:text-primary-600">Reservations</a>
                <a href="{{ route('membership') }}" class="block py-2 text-gray-700 hover:text-primary-600">Membership</a>
                <a href="{{ route('about') }}" class="block py-2 text-gray-700 hover:text-primary-600">About</a>
                <a href="{{ route('contact') }}" class="block py-2 text-gray-700 hover:text-primary-600">Contact</a>
            </div>
        </div>
    </nav>

    <!-- Success Message -->
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="fixed top-24 right-4 z-50 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg">
        {{ session('success') }}
    </div>
    @endif

    <!-- Main Content -->
    <main class="pt-20">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-2xl font-serif font-bold mb-4">The Lighthouse Cafe</h3>
                    <p class="text-gray-400">Coastal fine dining experience where elegance meets flavor.</p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="{{ route('menu') }}" class="hover:text-white transition">Menu</a></li>
                        <li><a href="{{ route('reservations.create') }}" class="hover:text-white transition">Reservations</a></li>
                        <li><a href="{{ route('membership') }}" class="hover:text-white transition">Membership</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-white transition">About Us</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Hours</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>Mon-Thu: 11am - 10pm</li>
                        <li>Fri-Sat: 11am - 11pm</li>
                        <li>Sunday: 10am - 9pm</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Contact</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>123 Harbor Drive</li>
                        <li>San Francisco, CA 94111</li>
                        <li>(415) 555-0123</li>
                        <li>info@lighthousecafe.com</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 The Lighthouse Cafe. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>