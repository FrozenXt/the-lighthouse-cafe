@extends('layouts.app')

@section('title', 'The Lighthouse Cafe - Coastal Fine Dining Experience')

@push('styles')
<style>
/* ═══════════════════════════════════════════════
   PARTICLE CANVAS
═══════════════════════════════════════════════ */
#particles-canvas {
    position: absolute;
    inset: 0;
    pointer-events: none;
    z-index: 1;
}

/* ═══════════════════════════════════════════════
   HERO SWIPER
═══════════════════════════════════════════════ */
.hero-swiper { width: 100%; height: 100vh; min-height: 520px; }

.hero-swiper .swiper-slide { position: relative; overflow: hidden; }

.hero-swiper .swiper-slide img {
    width: 100%; height: 100%;
    object-fit: cover;
    filter: brightness(.62);
    transform: scale(1.08);
    transition: transform 7s ease;
}
.hero-swiper .swiper-slide-active img { transform: scale(1); }

.hero-overlay {
    position: absolute; inset: 0; z-index: 2;
    background: linear-gradient(105deg,
        rgba(10,20,40,.92) 0%,
        rgba(10,20,40,.48) 55%,
        rgba(10,20,40,.68) 100%);
}
.hero-overlay-b {
    position: absolute; inset: 0; z-index: 2;
    background: linear-gradient(to top, rgba(10,20,40,.65) 0%, transparent 55%);
}
.hero-content {
    position: absolute; inset: 0;
    display: flex; align-items: center;
    z-index: 3;
}

/* Swiper nav arrows */
.swiper-button-next,
.swiper-button-prev {
    width: 52px !important; height: 52px !important;
    background: rgba(15,23,42,.55) !important;
    border: 1.5px solid rgba(245,158,11,.35) !important;
    border-radius: 50% !important;
    backdrop-filter: blur(8px);
    transition: all .3s !important;
}
.swiper-button-next:hover,
.swiper-button-prev:hover {
    background: rgba(245,158,11,.2) !important;
    border-color: rgba(245,158,11,.8) !important;
    transform: scale(1.1);
}
.swiper-button-next::after,
.swiper-button-prev::after {
    font-size: 16px !important;
    font-weight: 900 !important;
    color: #f59e0b !important;
}

/* Swiper pagination */
.swiper-pagination-bullet {
    background: rgba(203,213,225,.5) !important;
    width: 10px !important; height: 10px !important;
    opacity: 1 !important;
    transition: all .4s !important;
}
.swiper-pagination-bullet-active {
    background: #f59e0b !important;
    width: 36px !important;
    border-radius: 5px !important;
}

/* Scroll bounce arrow */
@keyframes scrollBounce {
    0%,100% { transform: translate(-50%, 0); opacity: .8; }
    50%      { transform: translate(-50%, 8px); opacity: .4; }
}
.scroll-bounce {
    position: absolute; bottom: 2rem; left: 50%;
    transform: translateX(-50%);
    z-index: 5;
    animation: scrollBounce 1.8s ease-in-out infinite;
    color: #f59e0b;
}

/* Hero eyebrow badge */
.hero-eyebrow {
    display: inline-block;
    background: rgba(245,158,11,.15);
    border: 1px solid rgba(245,158,11,.4);
    color: #fbbf24;
    font-size: .7rem;
    font-weight: 700;
    letter-spacing: .3em;
    text-transform: uppercase;
    padding: .35rem 1rem;
    border-radius: 2rem;
    margin-bottom: 1.2rem;
}

/* ═══════════════════════════════════════════════
   STATS BAR
═══════════════════════════════════════════════ */
.stat-number {
    font-size: 2.6rem;
    font-weight: 900;
    font-family: Georgia, serif;
    color: #f59e0b;
    line-height: 1;
}
@media (max-width:640px) { .stat-number { font-size: 2rem; } }

/* ═══════════════════════════════════════════════
   TABS
═══════════════════════════════════════════════ */
.tab-btn {
    padding: .7rem 2.2rem;
    border-radius: .6rem;
    font-weight: 700;
    font-size: .95rem;
    transition: all .3s;
    cursor: pointer;
    border: 1.5px solid transparent;
}
.tab-btn.active {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: #0f172a;
    box-shadow: 0 6px 28px rgba(245,158,11,.45);
}
.tab-btn:not(.active) {
    background: #e2e8f0;
    color: #475569;
    border-color: #e2e8f0;
}
.tab-btn:not(.active):hover {
    background: #cbd5e1;
    transform: translateY(-1px);
}

/* ═══════════════════════════════════════════════
   DISH CARDS
═══════════════════════════════════════════════ */
.dish-card {
    position: relative;
    background: #fff;
    border-radius: 1.25rem;
    box-shadow: 0 6px 28px rgba(0,0,0,.09);
    border: 1px solid #e2e8f0;
    overflow: hidden;
    transition: box-shadow .4s, transform .4s;
}
.dish-card:hover {
    box-shadow: 0 20px 56px rgba(0,0,0,.16);
    transform: translateY(-8px) scale(1.015);
}
.dish-card-img {
    height: 16rem;
    overflow: hidden;
    position: relative;
}
.dish-card-img img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform .7s ease;
}
.dish-card:hover .dish-card-img img { transform: scale(1.1); }
.dish-card-img::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(10,20,40,.5) 0%, transparent 55%);
    opacity: 0;
    transition: opacity .4s;
}
.dish-card:hover .dish-card-img::after { opacity: 1; }

/* ribbon */
.dish-ribbon {
    position: absolute;
    top: 1rem; left: 0;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: #0f172a;
    font-weight: 700;
    font-size: .72rem;
    padding: .3rem .9rem .3rem .7rem;
    border-radius: 0 .35rem .35rem 0;
    box-shadow: 2px 2px 10px rgba(0,0,0,.22);
    z-index: 5;
}
.dish-ribbon::before {
    content: '';
    position: absolute;
    left: 0; bottom: -4px;
    border: 4px solid transparent;
    border-right-color: #92400e;
    border-top-color: #92400e;
}

/* shimmer price */
@keyframes shimmer {
    0%   { background-position: -200% center; }
    100% { background-position:  200% center; }
}
.price-shimmer {
    background: linear-gradient(90deg, #d97706 25%, #fbbf24 50%, #d97706 75%);
    background-size: 200% auto;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: shimmer 2.5s linear infinite;
}

/* ═══════════════════════════════════════════════
   FEATURE CARDS
═══════════════════════════════════════════════ */
.feature-card {
    transition: transform .4s, box-shadow .4s, border-color .4s;
    cursor: default;
}
.feature-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 22px 56px rgba(0,0,0,.14);
    border-color: #f59e0b !important;
}
.feature-icon {
    transition: transform .4s;
}
.feature-card:hover .feature-icon {
    transform: rotate(12deg) scale(1.18);
}

/* ═══════════════════════════════════════════════
   CTA GLOWS
═══════════════════════════════════════════════ */
.cta-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(80px);
    pointer-events: none;
}
@keyframes orbPulse {
    0%,100% { opacity: .18; transform: scale(1); }
    50%      { opacity: .3;  transform: scale(1.08); }
}
.cta-orb { animation: orbPulse 4s ease-in-out infinite; }
.cta-orb-2 { animation-delay: 2s; }

/* floating badge */
@keyframes floatBadge {
    0%,100% { transform: translateY(0) rotate(-1deg); }
    50%      { transform: translateY(-8px) rotate(1deg); }
}
.float-badge { animation: floatBadge 4s ease-in-out infinite; }

/* panel fade for tabs */
.panel-fade { animation: panelFade .3s ease both; }
@keyframes panelFade {
    from { opacity:0; transform:translateY(10px); }
    to   { opacity:1; transform:translateY(0); }
}

/* section label */
.section-label {
    display: inline-block;
    color: #f59e0b;
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .28em;
    text-transform: uppercase;
    margin-bottom: .75rem;
}
</style>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════════════════
     HERO SECTION
═══════════════════════════════════════════════════════════ --}}
<section class="relative bg-slate-900 overflow-hidden">
    <canvas id="particles-canvas"></canvas>

    <div class="swiper hero-swiper">
        <div class="swiper-wrapper">

            {{-- Slide 1 --}}
            <div class="swiper-slide">
                <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=1920&h=800&fit=crop"
                     alt="Coastal Elegance" loading="eager">
                <div class="hero-overlay"></div>
                <div class="hero-overlay-b"></div>
                <div class="hero-content">
                    <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-10 w-full">
                        <div class="max-w-2xl">
                            <span class="hero-eyebrow animate__animated animate__fadeInDown animate__delay-1s">
                                ✦ Fine Dining ✦
                            </span>
                            <h1 class="text-5xl sm:text-7xl md:text-8xl font-serif font-extrabold text-amber-400 mb-5 drop-shadow-2xl leading-tight animate__animated animate__fadeInLeft animate__delay-1s">
                                Coastal<br>Elegance
                            </h1>
                            <p class="text-lg sm:text-2xl text-slate-200 mb-9 italic drop-shadow-lg animate__animated animate__fadeInLeft animate__delay-2s">
                                Where Ocean Meets Cuisine
                            </p>
                            <a href="{{ route('reservations.create') }}"
                               class="inline-block bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-900 font-bold py-4 px-9 rounded-xl text-lg shadow-2xl transition-all duration-300 hover:scale-105 animate__animated animate__fadeInUp animate__delay-2s">
                                Reserve Your Table
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Slide 2 --}}
            <div class="swiper-slide">
                <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=1920&h=800&fit=crop"
                     alt="Fine Dining Excellence" loading="lazy">
                <div class="hero-overlay"></div>
                <div class="hero-overlay-b"></div>
                <div class="hero-content">
                    <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-10 w-full">
                        <div class="max-w-2xl">
                            <span class="hero-eyebrow animate__animated animate__fadeInDown animate__delay-1s">
                                ✦ Award Winning ✦
                            </span>
                            <h1 class="text-5xl sm:text-7xl md:text-8xl font-serif font-extrabold text-amber-400 mb-5 drop-shadow-2xl leading-tight animate__animated animate__fadeInLeft animate__delay-1s">
                                Fine Dining<br>Excellence
                            </h1>
                            <p class="text-lg sm:text-2xl text-slate-200 mb-9 italic drop-shadow-lg animate__animated animate__fadeInLeft animate__delay-2s">
                                Crafted with Passion, Served with Pride
                            </p>
                            <a href="{{ route('reservations.create') }}"
                               class="inline-block bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-900 font-bold py-4 px-9 rounded-xl text-lg shadow-2xl transition-all duration-300 hover:scale-105 animate__animated animate__fadeInUp animate__delay-2s">
                                Explore Menu
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Slide 3 --}}
            <div class="swiper-slide">
                <img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=1920&h=800&fit=crop"
                     alt="Fresh from the Sea" loading="lazy">
                <div class="hero-overlay"></div>
                <div class="hero-overlay-b"></div>
                <div class="hero-content">
                    <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-10 w-full">
                        <div class="max-w-2xl">
                            <span class="hero-eyebrow animate__animated animate__fadeInDown animate__delay-1s">
                                ✦ Ocean Fresh ✦
                            </span>
                            <h1 class="text-5xl sm:text-7xl md:text-8xl font-serif font-extrabold text-amber-400 mb-5 drop-shadow-2xl leading-tight animate__animated animate__fadeInLeft animate__delay-1s">
                                Fresh from<br>the Sea
                            </h1>
                            <p class="text-lg sm:text-2xl text-slate-200 mb-9 italic drop-shadow-lg animate__animated animate__fadeInLeft animate__delay-2s">
                                Sustainable Seafood Daily
                            </p>
                            <a href="{{ route('reservations.create') }}"
                               class="inline-block bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-900 font-bold py-4 px-9 rounded-xl text-lg shadow-2xl transition-all duration-300 hover:scale-105 animate__animated animate__fadeInUp animate__delay-2s">
                                View Specials
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-pagination" style="bottom:2.75rem;"></div>
    </div>

    {{-- Scroll hint --}}
    <div class="scroll-bounce">
        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════
     STATS BAR
═══════════════════════════════════════════════════════════ --}}
<div id="statsBar"
     class="bg-slate-900 border-y border-amber-500/20 py-10"
     data-aos="fade-up" data-aos-duration="700">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-6 sm:gap-10 text-center">
        <div>
            <div class="stat-number" data-target="15">0</div>
            <p class="text-slate-400 text-xs tracking-widest uppercase mt-2">Years of Excellence</p>
        </div>
        <div>
            <div class="stat-number" data-target="200">0</div>
            <p class="text-slate-400 text-xs tracking-widest uppercase mt-2">Wines Curated</p>
        </div>
        <div>
            <div class="stat-number" data-target="50">0</div>
            <p class="text-slate-400 text-xs tracking-widest uppercase mt-2">Chef Years</p>
        </div>
        <div>
            <div class="stat-number" data-target="5000">0</div>
            <p class="text-slate-400 text-xs tracking-widest uppercase mt-2">Happy Guests</p>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════
     FEATURED SPECIALTIES  — backend untouched
═══════════════════════════════════════════════════════════ --}}
<section class="py-20 sm:py-28 bg-gradient-to-br from-slate-50 via-white to-slate-100 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-14">
            <span class="section-label" data-aos="fade-up">Our Kitchen</span>
            <h2 class="text-4xl sm:text-5xl md:text-6xl font-serif font-extrabold text-slate-800 mb-3 drop-shadow-sm"
                data-aos="fade-up" data-aos-delay="80">
                Featured Specialties
            </h2>
            <p class="text-lg sm:text-xl text-slate-500 italic"
               data-aos="fade-up" data-aos-delay="160">
                Handcrafted daily by our award-winning chefs
            </p>

            {{-- Tabs --}}
            <div class="flex justify-center gap-4 mt-10 flex-wrap"
                 data-aos="zoom-in" data-aos-delay="240">
                <button id="tab-day"   onclick="switchTab('day')"   class="tab-btn active">Dish of the Day</button>
                <button id="tab-week"  onclick="switchTab('week')"  class="tab-btn">Week's Special</button>
            </div>
        </div>

        {{-- Day panel --}}
        <div id="panel-day" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($featuredDay ?? [] as $dish)
                <div class="dish-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 110 }}" data-aos-duration="700">
                    <div class="dish-ribbon">⭐ {{ $dish->rating }}</div>
                    <div class="dish-card-img">
                        <img src="{{ $dish->image_url }}" alt="{{ $dish->name }}" loading="lazy">
                    </div>
                    <div class="p-6 sm:p-7">
                        <h3 class="text-2xl font-serif font-bold mb-2 text-slate-800">{{ $dish->name }}</h3>
                        <p class="text-slate-500 text-sm mb-5 leading-relaxed">{{ $dish->description }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-3xl font-extrabold price-shimmer">${{ $dish->price }}</span>
                            <a href="{{ route('orders.index') }}"
                               class="text-amber-600 hover:text-amber-700 font-bold text-sm transition-colors duration-200 group flex items-center gap-1">
                                Order Now
                                <span class="group-hover:translate-x-1 transition-transform duration-200 inline-block">→</span>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-16" data-aos="fade-up">
                    <div class="text-5xl mb-3 opacity-30">🍽️</div>
                    <p class="text-slate-400 text-lg">No featured dishes available today</p>
                </div>
            @endforelse
        </div>

        {{-- Week panel --}}
        <div id="panel-week" class="hidden grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($featuredWeek ?? [] as $dish)
                <div class="dish-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 110 }}" data-aos-duration="700">
                    <div class="dish-ribbon">⭐ {{ $dish->rating }}</div>
                    <div class="dish-card-img">
                        <img src="{{ $dish->image_url }}" alt="{{ $dish->name }}" loading="lazy">
                    </div>
                    <div class="p-6 sm:p-7">
                        <h3 class="text-2xl font-serif font-bold mb-2 text-slate-800">{{ $dish->name }}</h3>
                        <p class="text-slate-500 text-sm mb-5 leading-relaxed">{{ $dish->description }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-3xl font-extrabold price-shimmer">${{ $dish->price }}</span>
                            <a href="{{ route('orders.index') }}"
                               class="text-amber-600 hover:text-amber-700 font-bold text-sm transition-colors duration-200 group flex items-center gap-1">
                                Order Now
                                <span class="group-hover:translate-x-1 transition-transform duration-200 inline-block">→</span>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-16" data-aos="fade-up">
                    <div class="text-5xl mb-3 opacity-30">🍽️</div>
                    <p class="text-slate-400 text-lg">No featured dishes this week</p>
                </div>
            @endforelse
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════
     WHY CHOOSE US  — backend untouched
═══════════════════════════════════════════════════════════ --}}
<section class="py-20 sm:py-28 bg-gradient-to-br from-slate-100 via-slate-50 to-amber-50 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-14">
            <span class="section-label" data-aos="fade-up">Our Promise</span>
            <h2 class="text-4xl sm:text-5xl md:text-6xl font-serif font-extrabold text-slate-800 mb-3 drop-shadow-sm"
                data-aos="fade-up" data-aos-delay="80">
                Why The Lighthouse
            </h2>
            <p class="text-lg sm:text-xl text-slate-500 italic"
               data-aos="fade-up" data-aos-delay="160">
                Excellence in every detail
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 sm:gap-10">

            <div class="feature-card bg-white p-8 sm:p-10 rounded-2xl shadow-xl text-center border border-slate-200"
                 data-aos="flip-left" data-aos-duration="800" data-aos-delay="0">
                <div class="feature-icon w-20 h-20 bg-gradient-to-br from-amber-400 to-amber-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <span class="text-4xl">👨‍🍳</span>
                </div>
                <h3 class="text-2xl font-serif font-bold mb-3 text-slate-800">Master Chefs</h3>
                <p class="text-slate-500 leading-relaxed text-sm">Award-winning culinary team with 50+ years combined experience</p>
            </div>

            <div class="feature-card bg-white p-8 sm:p-10 rounded-2xl shadow-xl text-center border border-slate-200"
                 data-aos="flip-left" data-aos-duration="800" data-aos-delay="140">
                <div class="feature-icon w-20 h-20 bg-gradient-to-br from-slate-600 to-slate-700 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <span class="text-4xl">🌊</span>
                </div>
                <h3 class="text-2xl font-serif font-bold mb-3 text-slate-800">Fresh Seafood</h3>
                <p class="text-slate-500 leading-relaxed text-sm">Daily catches from local sustainable fisheries</p>
            </div>

            <div class="feature-card bg-white p-8 sm:p-10 rounded-2xl shadow-xl text-center border border-slate-200 sm:col-span-2 lg:col-span-1"
                 data-aos="flip-left" data-aos-duration="800" data-aos-delay="280">
                <div class="feature-icon w-20 h-20 bg-gradient-to-br from-amber-500 to-amber-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <span class="text-4xl">🍷</span>
                </div>
                <h3 class="text-2xl font-serif font-bold mb-3 text-slate-800">Premium Wine</h3>
                <p class="text-slate-500 leading-relaxed text-sm">Curated selection of 200+ international wines</p>
            </div>

        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════
     CTA SECTION  — backend routes untouched
═══════════════════════════════════════════════════════════ --}}
<section class="relative py-20 sm:py-28 bg-gradient-to-r from-slate-800 via-slate-900 to-slate-800 overflow-hidden">

    {{-- Grid pattern --}}
    <div class="absolute inset-0 opacity-[.07]"
         style="background-image:url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSAxMCAwIEwgMCAwIDAgMTAiIGZpbGw9Im5vbmUiIHN0cm9rZT0iIzMzMyIgc3Ryb2tlLXdpZHRoPSIxIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI2dyaWQpIi8+PC9zdmc+')">
    </div>

    {{-- Glow orbs --}}
    <div class="cta-orb" style="width:420px;height:420px;top:-80px;left:8%;background:radial-gradient(circle,#f59e0b,transparent 70%);"></div>
    <div class="cta-orb cta-orb-2" style="width:340px;height:340px;bottom:-60px;right:10%;background:radial-gradient(circle,#d97706,transparent 70%);"></div>

    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 text-center">

        <div class="float-badge inline-block bg-amber-500/15 border border-amber-500/35 text-amber-400 text-xs font-bold px-5 py-2 rounded-full mb-8 tracking-widest uppercase"
             data-aos="zoom-in" data-aos-duration="600">
            ✦ Exclusive Membership ✦
        </div>

        <h2 class="text-4xl sm:text-5xl md:text-6xl font-serif font-extrabold text-amber-400 mb-6 drop-shadow-2xl"
            data-aos="fade-up" data-aos-duration="700">
            Join Our Exclusive Club
        </h2>
        <p class="text-lg sm:text-xl text-slate-300 mb-10 italic"
           data-aos="fade-up" data-aos-delay="120" data-aos-duration="700">
            Enjoy exclusive benefits, priority reservations, and special member-only events
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center"
             data-aos="fade-up" data-aos-delay="240" data-aos-duration="700">
            <a href="{{ route('membership') }}"
               class="bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-900 font-bold py-4 sm:py-5 px-10 rounded-xl text-lg shadow-2xl transform hover:scale-105 transition-all duration-300">
                Become a Member
            </a>
            <a href="{{ route('reservations.create') }}"
               class="bg-transparent border-2 border-amber-400 text-amber-400 hover:bg-amber-400 hover:text-slate-900 font-bold py-4 sm:py-5 px-10 rounded-xl text-lg shadow-xl transform hover:scale-105 transition-all duration-300">
                Reserve a Table
            </a>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
/* ─────────────────────────────────────────────
   HERO SWIPER
───────────────────────────────────────────── */
new Swiper('.hero-swiper', {
    loop: true,
    speed: 1100,
    autoplay: { delay: 5000, disableOnInteraction: false },
    effect: 'fade',
    fadeEffect: { crossFade: true },
    navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
    pagination: { el: '.swiper-pagination', clickable: true },
});

/* ─────────────────────────────────────────────
   PARTICLE CANVAS
───────────────────────────────────────────── */
(function () {
    const canvas = document.getElementById('particles-canvas');
    const ctx    = canvas.getContext('2d');
    let W, H, particles = [];

    function resize() {
        W = canvas.width  = window.innerWidth;
        H = canvas.height = window.innerHeight;
    }

    function Particle() {
        this.reset = function () {
            this.x  = Math.random() * W;
            this.y  = Math.random() * H;
            this.r  = Math.random() * 1.4 + .3;
            this.vx = (Math.random() - .5) * .28;
            this.vy = (Math.random() - .5) * .28;
            this.o  = Math.random() * .45 + .08;
        };
        this.reset();
    }
    Particle.prototype.update = function () {
        this.x += this.vx; this.y += this.vy;
        if (this.x < 0 || this.x > W || this.y < 0 || this.y > H) this.reset();
    };
    Particle.prototype.draw = function () {
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.r, 0, Math.PI * 2);
        ctx.fillStyle = `rgba(245,158,11,${this.o})`;
        ctx.fill();
    };

    function init() {
        resize();
        particles = Array.from({ length: 90 }, () => new Particle());
    }
    function loop() {
        ctx.clearRect(0, 0, W, H);
        particles.forEach(p => { p.update(); p.draw(); });
        requestAnimationFrame(loop);
    }

    window.addEventListener('resize', resize, { passive: true });
    init(); loop();
})();

/* ─────────────────────────────────────────────
   COUNTER ANIMATION
───────────────────────────────────────────── */
(function () {
    let fired = false;
    const statsBar = document.getElementById('statsBar');
    if (!statsBar) return;

    const observer = new IntersectionObserver(entries => {
        if (entries[0].isIntersecting && !fired) {
            fired = true;
            observer.disconnect();
            document.querySelectorAll('.stat-number[data-target]').forEach(el => {
                const target = parseInt(el.dataset.target, 10);
                const cu = new countUp.CountUp(el, target, {
                    duration: 2.2,
                    suffix: '+',
                    useEasing: true,
                    separator: ',',
                });
                if (!cu.error) cu.start();
            });
        }
    }, { threshold: .4 });

    observer.observe(statsBar);
})();

/* ─────────────────────────────────────────────
   TAB SWITCHER
───────────────────────────────────────────── */
function switchTab(tab) {
    ['day', 'week'].forEach(t => {
        const panel = document.getElementById('panel-' + t);
        const btn   = document.getElementById('tab-'   + t);
        if (t === tab) {
            panel.classList.remove('hidden');
            panel.classList.add('panel-fade');
            btn.classList.add('active');
            setTimeout(() => panel.classList.remove('panel-fade'), 350);
            AOS.refresh();
        } else {
            panel.classList.add('hidden');
            btn.classList.remove('active');
        }
    });
}

/* ─────────────────────────────────────────────
   FEATURE CARD 3D TILT
───────────────────────────────────────────── */
document.querySelectorAll('.feature-card').forEach(card => {
    card.addEventListener('mousemove', e => {
        const r = card.getBoundingClientRect();
        const x = (e.clientX - r.left) / r.width  - .5;
        const y = (e.clientY - r.top)  / r.height - .5;
        card.style.transform = `translateY(-10px) rotateY(${x * 9}deg) rotateX(${-y * 6}deg)`;
    });
    card.addEventListener('mouseleave', () => {
        card.style.transform = '';
    });
});
</script>
@endpush
