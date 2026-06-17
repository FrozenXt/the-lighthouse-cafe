<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $favicon = $settings['site_favicon']->value ?? null;
    @endphp

    {{-- Favicon --}}
    @if($favicon)
        <link rel="icon" type="image/x-icon" href="{{ Storage::url($favicon) }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif

    <title>@yield('title', 'The Lighthouse Cafe - Coastal Fine Dining')</title>

    @vite(['resources/css/app.css'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }

        .animate-fadeIn {
            animation: fadeIn 0.2s ease-out;
        }
    </style>
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

        <div class="relative w-20 h-20 rounded-full overflow-hidden hover:scale-105 transition-transform">
          <img src="{{ asset('storage/' . site_setting('site_logo')) }}">
        </div>

        <div>
            <h1 class="text-2xl font-serif font-bold text-amber-400">
                {{ site_setting('site_name', 'The Lighthouse') }}
            </h1>

            <p class="text-xs text-slate-400 -mt-1 tracking-widest">
                {{ site_setting('site_tagline', 'CAFE') }}
            </p>
        </div>

    </a>
</div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-8">

                <a href="{{ route('home') }}" class="nav-link text-slate-200 hover:text-amber-400">Home</a>

                <!-- QR BUTTON -->
                <a href="#" onclick="openQR()"
                   class="nav-link text-slate-200 hover:text-amber-400">
                   View Menu
                </a>

                <a href="{{ route('orders.index') }}" class="nav-link text-slate-200 hover:text-amber-400">Order Online</a>
                <a href="{{ route('reservations.create') }}" class="nav-link text-slate-200 hover:text-amber-400">Reservations</a>
                <a href="{{ route('about') }}" class="nav-link text-slate-200 hover:text-amber-400">About</a>
                <a href="{{ route('contact') }}" class="nav-link text-slate-200 hover:text-amber-400">Contact</a>
                <a href="{{ route('orders.index') }}" class="btn-primary">Order Now</a>

            </div>

            <!-- Mobile button -->
            <div class="md:hidden flex items-center">
                <button @click="open = !open" class="text-slate-200">
                    ☰
                </button>
            </div>

        </div>

        <!-- Mobile Menu -->
        <div x-show="open" class="md:hidden p-4 bg-slate-800 rounded-lg mt-2">

    <a href="{{ route('home') }}" class="block py-2 text-slate-200">Home</a>

    <!-- QR MOBILE -->
    <a href="#" onclick="openQR()" class="block py-2 text-slate-200">View Menu</a>

    <a href="{{ route('orders.index') }}" class="block py-2 text-slate-200">Order</a>

    <a href="{{ route('reservations.create') }}" class="block py-2 text-slate-200">Reservations</a>

    {{-- NEW LINKS --}}
    <a href="{{ route('about') }}" class="block py-2 text-slate-200">About</a>

    <a href="{{ route('contact') }}" class="block py-2 text-slate-200">Contact</a>

</div>
    </div>
</nav>

<!-- MAIN -->
<main class="pt-20">
    @yield('content')
</main>

<!-- FOOTER (UNCHANGED) -->
<footer class="bg-gradient-to-r from-slate-950 via-slate-900 to-slate-950 text-slate-200 mt-20 border-t border-amber-500/20">

    <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-4 gap-10">

        <!-- Brand -->
       <div>
    <h2 class="text-2xl font-serif text-amber-400 font-bold">
        {{ site_setting('site_name', 'The Lighthouse Café') }}
    </h2>

    <p class="text-sm text-slate-400 mt-3 leading-relaxed">
        {{ site_setting('site_description', 'A coastal fine dining experience where flavors meet the sea breeze. Fresh ingredients, warm hospitality, and unforgettable moments.') }}
    </p>
</div>

        <!-- Quick Links -->
        <div>
            <h3 class="text-white font-semibold mb-4">Quick Links</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ route('home') }}" class="hover:text-amber-400">Home</a></li>
                <li><a href="{{ route('orders.index') }}" class="hover:text-amber-400">Order Online</a></li>
                <li><a href="{{ route('reservations.create') }}" class="hover:text-amber-400">Reservations</a></li>
                <li><a href="{{ route('about') }}" class="hover:text-amber-400">About Us</a></li>
                <li><a href="{{ route('contact') }}" class="hover:text-amber-400">Contact</a></li>
            </ul>
        </div>

      <!-- Contact -->
<div>
    <h3 class="text-white font-semibold mb-4">Contact</h3>

    <p class="text-sm text-slate-400">
        📍 {{ site_setting('restaurant_address', 'No address set') }}
    </p>

    <p class="text-sm text-slate-400 mt-2">
        📞 {{ site_setting('contact_phone', 'No phone set') }}
    </p>

    <p class="text-sm text-slate-400 mt-2">
        ✉ {{ site_setting('contact_email', 'No email set') }}
    </p>
</div>

        <!-- Opening Hours -->
        <div>
            <h3 class="text-white font-semibold mb-4">Opening Hours</h3>
            <p class="text-sm text-slate-400">Mon - Fri: 6:30 AM - 1:30 PM</p>
            <p class="text-sm text-slate-400 mt-2">Sat - Sun: 6:30 AM - 1:30 PM</p>
        </div>

    </div>

    <!-- Bottom Bar -->
  <div class="border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col md:flex-row justify-between items-center text-sm text-slate-500">

        <!-- Footer Text -->
        <p>
            {{ site_setting('footer_text', '© 2025 The Lighthouse Café. All rights reserved.') }}
        </p>

        <!-- Social Links -->
        <div class="flex space-x-4 mt-2 md:mt-0">

            @if(site_setting('social_facebook'))
                <a href="{{ site_setting('social_facebook') }}" target="_blank" class="hover:text-amber-400">
                    Facebook
                </a>
            @endif

            @if(site_setting('social_instagram'))
                <a href="{{ site_setting('social_instagram') }}" target="_blank" class="hover:text-amber-400">
                    Instagram
                </a>
            @endif

            @if(site_setting('social_tiktok'))
                <a href="{{ site_setting('social_tiktok') }}" target="_blank" class="hover:text-amber-400">
                    TikTok
                </a>
            @endif

        </div>

    </div>
</div>

</footer>

<!-- QR MODAL -->
<div id="qrModal"
    class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">

    <div class="bg-white p-6 rounded-xl text-center relative animate-fadeIn">

        <button onclick="closeQR()" class="absolute top-2 right-3 text-xl">&times;</button>

        <h2 class="text-lg font-bold mb-2">Scan Menu</h2>
        <p class="text-sm text-gray-500 mb-3">Use phone to view menu</p>

        <canvas id="qrCanvas"></canvas>

        <a href="{{ route('menu') }}" target="_blank"
           class="block mt-3 text-amber-500 text-sm">
           Open directly
        </a>
    </div>
</div>

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>

<script>
let qrGenerated = false;

function openQR() {
    let modal = document.getElementById('qrModal');
    let canvas = document.getElementById('qrCanvas');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    if (!qrGenerated) {
        QRCode.toCanvas(canvas, "{{ url('menu.pdf') }}");
        qrGenerated = true;
    }
}

function closeQR() {
    let modal = document.getElementById('qrModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>

</body>
</html>
