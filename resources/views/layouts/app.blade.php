<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                        <img src="{{ asset('images/lighthouselogo.png') }}" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h1 class="text-2xl font-serif font-bold text-amber-400">The Lighthouse</h1>
                        <p class="text-xs text-slate-400 -mt-1 tracking-widest">CAFE</p>
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
        </div>
    </div>
</nav>

<!-- MAIN -->
<main class="pt-20">
    @yield('content')
</main>

<!-- FOOTER (UNCHANGED) -->
<footer class="bg-slate-900 text-white mt-20 p-10 text-center">
    © 2025 The Lighthouse Cafe
</footer>

<!-- QR MODAL -->
<div id="qrModal"
    class="fixed inset-0 bg-black/70 hidden items-center justify-center z-50">

    <div class="bg-white p-6 rounded-xl text-center relative animate-fadeIn">

        <button onclick="closeQR()" class="absolute top-2 right-3 text-xl">&times;</button>

        <h2 class="text-lg font-bold mb-2">Scan Menu</h2>
        <p class="text-sm text-gray-500 mb-3">Use phone to view menu</p>

        <canvas id="qrCanvas"></canvas>

        <a href="{{ url('menu.pdf') }}" target="_blank"
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
