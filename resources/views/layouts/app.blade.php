<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $logo    = site_setting('site_logo');
        $favicon = site_setting('site_favicon');
    @endphp

    <link rel="icon" type="image/x-icon"
          href="{{ $favicon ? asset('storage/' . $favicon) : asset('favicon.ico') }}">

    <title>@yield('title', 'The Lighthouse Cafe - Coastal Fine Dining')</title>

    @vite(['resources/css/app.css'])

    {{-- ── Animation Libraries (global) ── --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.css"/>

    {{-- Alpine JS --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* ─────────────────────────────────────
           BASE
        ───────────────────────────────────── */
        html { scroll-behavior: smooth; }
        [x-cloak] { display: none !important; }

        body {
            opacity: 0;
            animation: pageReveal .5s ease .05s forwards;
        }
        @keyframes pageReveal { to { opacity: 1; } }

        /* ─────────────────────────────────────
           NAVBAR
        ───────────────────────────────────── */
        #mainNav {
            transition: background .35s ease, box-shadow .35s ease, padding .35s ease;
        }
        #mainNav.nav-scrolled {
            background: rgba(10,15,30,.97) !important;
            box-shadow: 0 4px 40px rgba(0,0,0,.55) !important;
            border-bottom-color: rgba(245,158,11,.5) !important;
        }

        .nav-link {
            position: relative;
            padding-bottom: 3px;
            font-size: .875rem;
            font-weight: 500;
            letter-spacing: .01em;
            transition: color .25s;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            left: 0; bottom: 0;
            width: 0; height: 2px;
            background: #f59e0b;
            border-radius: 2px;
            transition: width .3s ease;
        }
        .nav-link:hover { color: #f59e0b !important; }
        .nav-link:hover::after,
        .nav-link.active::after { width: 100%; }
        .nav-link.active { color: #f59e0b !important; }

        .btn-primary {
            display: inline-block;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #0f172a;
            font-weight: 700;
            font-size: .875rem;
            padding: .55rem 1.4rem;
            border-radius: .5rem;
            transition: transform .25s, box-shadow .25s, filter .25s;
            box-shadow: 0 4px 20px rgba(245,158,11,.4);
        }
        .btn-primary:hover {
            filter: brightness(1.1);
            transform: translateY(-2px) scale(1.04);
            box-shadow: 0 8px 30px rgba(245,158,11,.55);
        }

        /* mobile menu slide */
        .mobile-menu-enter { animation: mobileIn .22s ease forwards; }
        @keyframes mobileIn {
            from { opacity:0; transform:translateY(-8px); }
            to   { opacity:1; transform:translateY(0); }
        }

        /* ─────────────────────────────────────
           QR MODAL
        ───────────────────────────────────── */
        @keyframes fadeInScale {
            from { opacity:0; transform:scale(.88); }
            to   { opacity:1; transform:scale(1); }
        }
        .animate-fadeIn { animation: fadeInScale .22s ease-out forwards; }

        /* ─────────────────────────────────────
           CART / CHECKOUT BOTTOM POPUP
        ───────────────────────────────────── */
        #cartPopup {
            position: fixed;
            bottom: 0; left: 0; right: 0;
            z-index: 55;
            transform: translateY(100%);
            transition: transform .42s cubic-bezier(.22,1,.36,1), opacity .3s ease;
            opacity: 0;
            pointer-events: none;
        }
        #cartPopup.cart-open {
            transform: translateY(0);
            opacity: 1;
            pointer-events: all;
        }

        /* inner panel */
        .cart-panel {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border-top: 2px solid rgba(245,158,11,.35);
            border-radius: 1.25rem 1.25rem 0 0;
            box-shadow: 0 -16px 64px rgba(0,0,0,.55);
            max-height: 85vh;
            overflow-y: auto;
        }

        /* close button */
        .cart-close-btn {
            position: absolute;
            top: .9rem; right: 1rem;
            width: 2rem; height: 2rem;
            display: flex; align-items: center; justify-content: center;
            background: rgba(245,158,11,.15);
            border: 1px solid rgba(245,158,11,.3);
            border-radius: 50%;
            color: #f59e0b;
            font-size: 1.1rem;
            line-height: 1;
            cursor: pointer;
            transition: background .2s, transform .2s;
            z-index: 10;
        }
        .cart-close-btn:hover {
            background: rgba(245,158,11,.35);
            transform: scale(1.12) rotate(90deg);
        }

        /* drag handle */
        .cart-drag-handle {
            width: 3rem; height: 4px;
            background: rgba(148,163,184,.4);
            border-radius: 2px;
            margin: .7rem auto .2rem;
        }

        /* cart item row */
        .cart-item-row {
            display: flex;
            align-items: center;
            gap: .75rem;
            padding: .65rem 0;
            border-bottom: 1px solid rgba(148,163,184,.12);
            animation: slideItemIn .3s ease both;
        }
        @keyframes slideItemIn {
            from { opacity:0; transform:translateX(-12px); }
            to   { opacity:1; transform:translateX(0); }
        }
        .cart-item-row:last-child { border-bottom: none; }

        /* qty controls */
        .qty-btn {
            width: 1.8rem; height: 1.8rem;
            border-radius: .35rem;
            background: rgba(245,158,11,.15);
            border: 1px solid rgba(245,158,11,.3);
            color: #f59e0b;
            font-weight: 700;
            font-size: 1rem;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: background .2s;
        }
        .qty-btn:hover { background: rgba(245,158,11,.35); }

        /* checkout button pulse */
        @keyframes ctaPulse {
            0%,100% { box-shadow: 0 0 0 0 rgba(245,158,11,.5); }
            50%      { box-shadow: 0 0 0 10px rgba(245,158,11,0); }
        }
        .checkout-pulse { animation: ctaPulse 2s ease-in-out infinite; }

        /* floating cart trigger */
        #cartTrigger {
            position: fixed;
            bottom: 1.5rem; right: 1.5rem;
            z-index: 54;
            width: 3.5rem; height: 3.5rem;
            border-radius: 50%;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: #0f172a;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 8px 32px rgba(245,158,11,.5);
            cursor: pointer;
            transition: transform .3s, box-shadow .3s;
            animation: cartFloat 3s ease-in-out infinite;
        }
        @keyframes cartFloat {
            0%,100% { transform:translateY(0); }
            50%      { transform:translateY(-6px); }
        }
        #cartTrigger:hover {
            animation: none;
            transform: scale(1.12);
            box-shadow: 0 12px 40px rgba(245,158,11,.7);
        }
        #cartTrigger .cart-badge {
            position: absolute;
            top: -.25rem; right: -.25rem;
            background: #ef4444;
            color: #fff;
            font-size: .65rem;
            font-weight: 700;
            width: 1.2rem; height: 1.2rem;
            border-radius: 50%;
            display: flex; align-items:center; justify-content:center;
            border: 2px solid #0f172a;
            animation: badgePop .35s cubic-bezier(.34,1.56,.64,1) both;
        }
        @keyframes badgePop {
            from { transform:scale(0); }
            to   { transform:scale(1); }
        }

        /* backdrop */
        #cartBackdrop {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.45);
            z-index: 53;
            opacity: 0;
            pointer-events: none;
            transition: opacity .3s ease;
            backdrop-filter: blur(2px);
        }
        #cartBackdrop.cart-open { opacity:1; pointer-events:all; }

        /* scrollbar for cart panel */
        .cart-panel::-webkit-scrollbar { width:4px; }
        .cart-panel::-webkit-scrollbar-track { background:transparent; }
        .cart-panel::-webkit-scrollbar-thumb { background:rgba(245,158,11,.3); border-radius:4px; }

        /* ─────────────────────────────────────
           FOOTER
        ───────────────────────────────────── */
        footer a { transition: color .2s; }

        .footer-social-icon {
            width: 2.25rem; height: 2.25rem;
            border-radius: 50%;
            background: rgba(30,41,59,1);
            border: 1px solid rgba(245,158,11,.2);
            color: #94a3b8;
            display: flex; align-items:center; justify-content:center;
            font-size: .75rem; font-weight:700;
            transition: background .25s, color .25s, border-color .25s, transform .25s;
        }
        .footer-social-icon:hover {
            background: #f59e0b;
            color: #0f172a;
            border-color: #f59e0b;
            transform: translateY(-2px) scale(1.1);
        }

        /* ─────────────────────────────────────
           REDUCED MOTION
        ───────────────────────────────────── */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: .01ms !important;
                transition-duration: .01ms !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body class="bg-slate-100">

{{-- ══════════════════════════════════════════
     NAVIGATION
══════════════════════════════════════════ --}}
<nav id="mainNav"
     x-data="{ open: false }"
     class="bg-gradient-to-r from-slate-800 via-slate-900 to-slate-800 shadow-2xl fixed w-full top-0 z-50 border-b border-amber-500/20">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                <div class="relative w-14 h-14 rounded-full overflow-hidden ring-2 ring-transparent group-hover:ring-amber-400 transition-all duration-300 group-hover:scale-105">
                    <img src="{{ asset('storage/' . site_setting('site_logo')) }}"
                         alt="{{ site_setting('site_name', 'The Lighthouse') }}"
                         class="w-full h-full object-cover">
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-serif font-bold text-amber-400 leading-tight">
                        {{ site_setting('site_name', 'The Lighthouse') }}
                    </h1>
                    <p class="text-[10px] text-slate-400 tracking-[.2em] uppercase">
                        {{ site_setting('site_tagline', 'Cafe') }}
                    </p>
                </div>
            </a>

            {{-- Desktop links --}}
            <div class="hidden lg:flex items-center space-x-7">
                <a href="{{ route('home') }}"
                   class="nav-link text-slate-300 {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                <a href="#" onclick="openQR(); return false;"
                   class="nav-link text-slate-300">View Menu</a>
                <a href="{{ route('orders.index') }}"
                   class="nav-link text-slate-300 {{ request()->routeIs('orders.*') ? 'active' : '' }}">Order Online</a>
                <a href="{{ route('reservations.create') }}"
                   class="nav-link text-slate-300 {{ request()->routeIs('reservations.*') ? 'active' : '' }}">Reservations</a>
                <a href="{{ route('about') }}"
                   class="nav-link text-slate-300 {{ request()->routeIs('about') ? 'active' : '' }}">About</a>
                <a href="{{ route('contact') }}"
                   class="nav-link text-slate-300 {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
                <a href="{{ route('orders.index') }}" class="btn-primary ml-2">Order Now</a>
            </div>

            {{-- Hamburger --}}
            <button @click="open = !open"
                    class="lg:hidden p-2 rounded-lg text-slate-300 hover:text-amber-400 hover:bg-slate-700/50 transition-all duration-200"
                    aria-label="Toggle navigation">
                <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="open" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Mobile menu --}}
        <div x-show="open"
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-3"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-3"
             class="lg:hidden pb-5 border-t border-slate-700/40 mt-1">
            <div class="pt-3 space-y-1">
                <a href="{{ route('home') }}"
                   class="flex items-center py-2.5 px-4 text-slate-200 hover:text-amber-400 hover:bg-slate-700/50 rounded-lg transition-all text-sm font-medium {{ request()->routeIs('home') ? 'text-amber-400 bg-slate-700/30' : '' }}">
                    🏠 Home
                </a>
                <a href="#" onclick="openQR(); return false;"
                   class="flex items-center py-2.5 px-4 text-slate-200 hover:text-amber-400 hover:bg-slate-700/50 rounded-lg transition-all text-sm font-medium">
                    📋 View Menu
                </a>
                <a href="{{ route('orders.index') }}"
                   class="flex items-center py-2.5 px-4 text-slate-200 hover:text-amber-400 hover:bg-slate-700/50 rounded-lg transition-all text-sm font-medium {{ request()->routeIs('orders.*') ? 'text-amber-400 bg-slate-700/30' : '' }}">
                    🛒 Order Online
                </a>
                <a href="{{ route('reservations.create') }}"
                   class="flex items-center py-2.5 px-4 text-slate-200 hover:text-amber-400 hover:bg-slate-700/50 rounded-lg transition-all text-sm font-medium">
                    📅 Reservations
                </a>
                <a href="{{ route('about') }}"
                   class="flex items-center py-2.5 px-4 text-slate-200 hover:text-amber-400 hover:bg-slate-700/50 rounded-lg transition-all text-sm font-medium">
                    ℹ️ About
                </a>
                <a href="{{ route('contact') }}"
                   class="flex items-center py-2.5 px-4 text-slate-200 hover:text-amber-400 hover:bg-slate-700/50 rounded-lg transition-all text-sm font-medium">
                    ✉️ Contact
                </a>
                <div class="pt-2 px-4">
                    <a href="{{ route('orders.index') }}" class="btn-primary block text-center">Order Now</a>
                </div>
            </div>
        </div>
    </div>
</nav>

{{-- ══════════════════════════════════════════
     MAIN
══════════════════════════════════════════ --}}
<main class="pt-20">
    @yield('content')
</main>

{{-- ══════════════════════════════════════════
     FOOTER
══════════════════════════════════════════ --}}
<footer class="bg-gradient-to-r from-slate-950 via-slate-900 to-slate-950 text-slate-200 mt-20 border-t border-amber-500/20">

    <div class="max-w-7xl mx-auto px-6 py-14 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">

        {{-- Brand --}}
        <div data-aos="fade-up" data-aos-duration="600">
            <h2 class="text-2xl font-serif text-amber-400 font-bold">
                {{ site_setting('site_name', 'The Lighthouse Café') }}
            </h2>
            <p class="text-sm text-slate-400 mt-3 leading-relaxed">
                {{ site_setting('site_description', 'A coastal fine dining experience where flavors meet the sea breeze.') }}
            </p>
            <div class="flex space-x-3 mt-5">
                @if(site_setting('social_facebook'))
                    <a href="{{ site_setting('social_facebook') }}" target="_blank" class="footer-social-icon">f</a>
                @endif
                @if(site_setting('social_instagram'))
                    <a href="{{ site_setting('social_instagram') }}" target="_blank" class="footer-social-icon">ig</a>
                @endif
                @if(site_setting('social_tiktok'))
                    <a href="{{ site_setting('social_tiktok') }}" target="_blank" class="footer-social-icon">tt</a>
                @endif
            </div>
        </div>

        {{-- Quick Links --}}
        <div data-aos="fade-up" data-aos-delay="100" data-aos-duration="600">
            <h3 class="text-white font-semibold mb-5 text-xs tracking-widest uppercase">Quick Links</h3>
            <ul class="space-y-3 text-sm">
                @foreach([['route'=>'home','label'=>'Home'],['route'=>'orders.index','label'=>'Order Online'],['route'=>'reservations.create','label'=>'Reservations'],['route'=>'about','label'=>'About Us'],['route'=>'contact','label'=>'Contact']] as $link)
                <li>
                    <a href="{{ route($link['route']) }}"
                       class="text-slate-400 hover:text-amber-400 transition-colors flex items-center gap-2 group">
                        <span class="w-4 h-px bg-amber-500/40 group-hover:w-6 transition-all duration-300 inline-block"></span>
                        {{ $link['label'] }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

        {{-- Contact --}}
        <div data-aos="fade-up" data-aos-delay="200" data-aos-duration="600">
            <h3 class="text-white font-semibold mb-5 text-xs tracking-widest uppercase">Contact</h3>
            <div class="space-y-3 text-sm text-slate-400">
                <p class="flex items-start gap-3">
                    <span class="mt-0.5">📍</span>
                    <span>{{ site_setting('restaurant_address', 'No address set') }}</span>
                </p>
                <p class="flex items-center gap-3">
                    <span>📞</span>
                    <a href="tel:{{ site_setting('contact_phone') }}" class="hover:text-amber-400 transition-colors">
                        {{ site_setting('contact_phone', 'No phone set') }}
                    </a>
                </p>
                <p class="flex items-center gap-3">
                    <span>✉️</span>
                    <a href="mailto:{{ site_setting('contact_email') }}" class="hover:text-amber-400 transition-colors truncate">
                        {{ site_setting('contact_email', 'No email set') }}
                    </a>
                </p>
            </div>
        </div>

        {{-- Hours --}}
        <div data-aos="fade-up" data-aos-delay="300" data-aos-duration="600">
            <h3 class="text-white font-semibold mb-5 text-xs tracking-widest uppercase">Opening Hours</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between items-center">
                    <span class="text-slate-400">Mon – Fri</span>
                    <span class="text-amber-400 font-semibold">6:30 AM – 1:30 PM</span>
                </div>
                <div class="w-full h-px bg-slate-800/80"></div>
                <div class="flex justify-between items-center">
                    <span class="text-slate-400">Sat – Sun</span>
                    <span class="text-amber-400 font-semibold">6:30 AM – 1:30 PM</span>
                </div>
                <div class="mt-4 p-3 bg-amber-500/10 border border-amber-500/20 rounded-lg">
                    <p class="text-xs text-amber-400/80 text-center">Reservations recommended on weekends</p>
                </div>
            </div>
        </div>

    </div>

    <div class="border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-6 py-4 flex flex-col sm:flex-row justify-between items-center gap-2 text-xs text-slate-500">
            <p>{{ site_setting('footer_text', '© 2025 The Lighthouse Café. All rights reserved.') }}</p>
            <div class="flex space-x-4">
                @if(site_setting('social_facebook'))
                    <a href="{{ site_setting('social_facebook') }}" target="_blank" class="hover:text-amber-400 transition-colors">Facebook</a>
                @endif
                @if(site_setting('social_instagram'))
                    <a href="{{ site_setting('social_instagram') }}" target="_blank" class="hover:text-amber-400 transition-colors">Instagram</a>
                @endif
                @if(site_setting('social_tiktok'))
                    <a href="{{ site_setting('social_tiktok') }}" target="_blank" class="hover:text-amber-400 transition-colors">TikTok</a>
                @endif
            </div>
        </div>
    </div>
</footer>

{{-- ══════════════════════════════════════════
     QR MODAL
══════════════════════════════════════════ --}}
<div id="qrModal"
     class="fixed inset-0 bg-black/70 hidden items-center justify-center z-[60] backdrop-blur-sm">
    <div class="bg-white p-8 rounded-2xl text-center relative animate-fadeIn shadow-2xl max-w-xs w-full mx-4">
        <button onclick="closeQR()"
                class="absolute top-3 right-3 w-8 h-8 flex items-center justify-center bg-slate-100 hover:bg-red-50 hover:text-red-500 text-slate-500 rounded-full text-xl font-bold transition-all duration-200 hover:scale-110 hover:rotate-90">
            &times;
        </button>
        <h2 class="text-lg font-bold mb-1 text-slate-800">Scan to View Menu</h2>
        <p class="text-sm text-slate-500 mb-4">Use your phone camera</p>
        <canvas id="qrCanvas" class="mx-auto rounded-lg"></canvas>
        <a href="{{ route('menu') }}" target="_blank"
           class="block mt-4 text-amber-500 hover:text-amber-600 text-sm font-semibold transition-colors">
            Open directly →
        </a>
    </div>
</div>

{{-- ══════════════════════════════════════════
     CART FLOATING TRIGGER
══════════════════════════════════════════ --}}
<button id="cartTrigger"
        onclick="openCart()"
        aria-label="View Cart"
        class="group">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
    </svg>
    <span class="cart-badge" id="cartBadge" style="display:none">0</span>
</button>

{{-- ══════════════════════════════════════════
     CART BACKDROP
══════════════════════════════════════════ --}}
<div id="cartBackdrop" onclick="closeCart()"></div>

{{-- ══════════════════════════════════════════
     CART BOTTOM POPUP
══════════════════════════════════════════ --}}
<div id="cartPopup" role="dialog" aria-modal="true" aria-label="Shopping Cart">
    <div class="cart-panel relative">

        {{-- Drag handle --}}
        <div class="cart-drag-handle"></div>

        {{-- Close X --}}
        <button onclick="closeCart()"
                class="cart-close-btn"
                aria-label="Close cart">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <div class="px-5 pb-2 pt-1">
            {{-- Header --}}
            <div class="flex items-center justify-between mb-4 pr-8">
                <div class="flex items-center gap-2">
                    <span class="text-2xl">🛒</span>
                    <h2 class="text-xl font-serif font-bold text-white">Your Order</h2>
                </div>
                <span id="cartItemCount"
                      class="text-xs font-semibold bg-amber-500/20 text-amber-400 border border-amber-500/30 px-3 py-1 rounded-full">
                    0 items
                </span>
            </div>

            {{-- Empty state --}}
            <div id="cartEmpty" class="py-10 text-center">
                <div class="text-5xl mb-3 opacity-40">🍽️</div>
                <p class="text-slate-400 text-sm">Your cart is empty</p>
                <a href="{{ route('orders.index') }}"
                   class="inline-block mt-4 text-amber-400 hover:text-amber-300 text-sm font-semibold transition-colors">
                    Browse Menu →
                </a>
            </div>

            {{-- Cart items list --}}
            <div id="cartItemsList" class="space-y-0 hidden max-h-56 overflow-y-auto pr-1"></div>

            {{-- Divider --}}
            <div id="cartDivider" class="hidden my-4 h-px bg-slate-700/60"></div>

            {{-- Totals & Checkout --}}
            <div id="cartFooter" class="hidden pb-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-slate-400 text-sm">Subtotal</span>
                    <span id="cartSubtotal" class="text-white font-semibold text-sm">$0.00</span>
                </div>
                <div class="flex justify-between items-center mb-4">
                    <span class="text-slate-400 text-sm">Service charge (10%)</span>
                    <span id="cartService" class="text-white font-semibold text-sm">$0.00</span>
                </div>
                <div class="flex justify-between items-center mb-5 py-3 border-t border-slate-700/60">
                    <span class="text-white font-bold text-base">Total</span>
                    <span id="cartTotal" class="text-amber-400 font-extrabold text-xl">$0.00</span>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <button onclick="clearCart()"
                            class="py-3 px-4 rounded-xl bg-slate-700/60 hover:bg-red-500/20 text-slate-300 hover:text-red-400 border border-slate-600 hover:border-red-500/40 font-semibold text-sm transition-all duration-300">
                        🗑️ Clear Cart
                    </button>
                    <a href="{{ route('orders.index') }}"
                       class="py-3 px-4 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-900 font-bold text-sm text-center transition-all duration-300 checkout-pulse flex items-center justify-center gap-1">
                        Checkout →
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════
     GLOBAL SCRIPTS — always after body content
══════════════════════════════════════════ --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/countup.js/2.8.0/countUp.umd.js"></script>
<script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>

<script>
/* ─────────────────────────────────────────────
   AOS INIT
───────────────────────────────────────────── */
AOS.init({ once: true, offset: 70, duration: 720, easing: 'ease-out-cubic' });

/* ─────────────────────────────────────────────
   NAVBAR SCROLL SHRINK
───────────────────────────────────────────── */
(function () {
    const nav = document.getElementById('mainNav');
    function onScroll() {
        nav.classList.toggle('nav-scrolled', window.scrollY > 60);
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
})();

/* ─────────────────────────────────────────────
   QR MODAL
───────────────────────────────────────────── */
let qrGenerated = false;
function openQR() {
    const modal  = document.getElementById('qrModal');
    const canvas = document.getElementById('qrCanvas');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    if (!qrGenerated) {
        QRCode.toCanvas(canvas, "{{ url('menu.pdf') }}", { width: 220 });
        qrGenerated = true;
    }
}
function closeQR() {
    const modal = document.getElementById('qrModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
document.getElementById('qrModal').addEventListener('click', function (e) {
    if (e.target === this) closeQR();
});
document.addEventListener('keydown', e => { if (e.key === 'Escape') { closeQR(); closeCart(); } });

/* ─────────────────────────────────────────────
   CART SYSTEM
───────────────────────────────────────────── */
let cart = JSON.parse(localStorage.getItem('lh_cart') || '[]');

function saveCart() {
    localStorage.setItem('lh_cart', JSON.stringify(cart));
    renderCart();
}

function addToCart(id, name, price, image) {
    const existing = cart.find(i => i.id === id);
    if (existing) {
        existing.qty++;
    } else {
        cart.push({ id, name, price: parseFloat(price), image: image || '', qty: 1 });
    }
    saveCart();
    openCart();

    // toast
    showToast(`${name} added to cart`);
}

function removeFromCart(id) {
    cart = cart.filter(i => i.id !== id);
    saveCart();
}

function changeQty(id, delta) {
    const item = cart.find(i => i.id === id);
    if (!item) return;
    item.qty += delta;
    if (item.qty <= 0) cart = cart.filter(i => i.id !== id);
    saveCart();
}

function clearCart() {
    cart = [];
    saveCart();
}

function renderCart() {
    const list      = document.getElementById('cartItemsList');
    const empty     = document.getElementById('cartEmpty');
    const footer    = document.getElementById('cartFooter');
    const divider   = document.getElementById('cartDivider');
    const countEl   = document.getElementById('cartItemCount');
    const badge     = document.getElementById('cartBadge');
    const subtotalEl= document.getElementById('cartSubtotal');
    const serviceEl = document.getElementById('cartService');
    const totalEl   = document.getElementById('cartTotal');

    const totalItems = cart.reduce((s, i) => s + i.qty, 0);
    const subtotal   = cart.reduce((s, i) => s + i.price * i.qty, 0);
    const service    = subtotal * 0.1;
    const total      = subtotal + service;

    // badge
    if (totalItems > 0) {
        badge.style.display = 'flex';
        badge.textContent   = totalItems > 9 ? '9+' : totalItems;
    } else {
        badge.style.display = 'none';
    }

    // count label
    countEl.textContent = `${totalItems} item${totalItems !== 1 ? 's' : ''}`;

    if (cart.length === 0) {
        list.classList.add('hidden');
        footer.classList.add('hidden');
        divider.classList.add('hidden');
        empty.classList.remove('hidden');
        return;
    }

    empty.classList.add('hidden');
    list.classList.remove('hidden');
    footer.classList.remove('hidden');
    divider.classList.remove('hidden');

    list.innerHTML = cart.map(item => `
        <div class="cart-item-row">
            ${item.image
                ? `<img src="${item.image}" class="w-12 h-12 rounded-lg object-cover flex-shrink-0 border border-slate-600" alt="${item.name}">`
                : `<div class="w-12 h-12 rounded-lg bg-slate-700 flex-shrink-0 flex items-center justify-center text-xl">🍽️</div>`
            }
            <div class="flex-1 min-w-0">
                <p class="text-white text-sm font-semibold truncate">${item.name}</p>
                <p class="text-amber-400 text-xs font-bold mt-0.5">$${(item.price * item.qty).toFixed(2)}</p>
            </div>
            <div class="flex items-center gap-1 flex-shrink-0">
                <button onclick="changeQty(${item.id}, -1)" class="qty-btn" aria-label="Decrease">−</button>
                <span class="text-white font-bold text-sm w-6 text-center">${item.qty}</span>
                <button onclick="changeQty(${item.id}, +1)" class="qty-btn" aria-label="Increase">+</button>
                <button onclick="removeFromCart(${item.id})"
                        class="ml-1 w-7 h-7 flex items-center justify-center rounded-md bg-red-500/15 hover:bg-red-500/30 text-red-400 hover:text-red-300 transition-all text-sm"
                        aria-label="Remove item">✕</button>
            </div>
        </div>
    `).join('');

    subtotalEl.textContent = `$${subtotal.toFixed(2)}`;
    serviceEl.textContent  = `$${service.toFixed(2)}`;
    totalEl.textContent    = `$${total.toFixed(2)}`;
}

function openCart() {
    document.getElementById('cartPopup').classList.add('cart-open');
    document.getElementById('cartBackdrop').classList.add('cart-open');
    document.body.style.overflow = 'hidden';
}

function closeCart() {
    document.getElementById('cartPopup').classList.remove('cart-open');
    document.getElementById('cartBackdrop').classList.remove('cart-open');
    document.body.style.overflow = '';
}

/* ─────────────────────────────────────────────
   TOAST NOTIFICATION
───────────────────────────────────────────── */
function showToast(msg) {
    const t = document.createElement('div');
    t.className = 'fixed top-24 right-4 z-[70] bg-slate-800 border border-amber-500/40 text-white text-sm font-medium px-4 py-3 rounded-xl shadow-2xl flex items-center gap-2';
    t.style.cssText = 'animation: slideToastIn .35s cubic-bezier(.22,1,.36,1) forwards; max-width: 260px;';
    t.innerHTML = `<span class="text-amber-400">✓</span>${msg}`;
    document.body.appendChild(t);
    setTimeout(() => {
        t.style.animation = 'slideToastOut .3s ease forwards';
        setTimeout(() => t.remove(), 300);
    }, 2600);
}

// inject toast keyframes
const toastStyle = document.createElement('style');
toastStyle.textContent = `
    @keyframes slideToastIn  { from{opacity:0;transform:translateX(110%)} to{opacity:1;transform:translateX(0)} }
    @keyframes slideToastOut { from{opacity:1;transform:translateX(0)} to{opacity:0;transform:translateX(110%)} }
`;
document.head.appendChild(toastStyle);

// init on load
renderCart();

// expose globally so order pages can call addToCart(...)
window.addToCart = addToCart;
</script>

@stack('scripts')

</body>
</html>
