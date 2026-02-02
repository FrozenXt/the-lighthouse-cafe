@extends('layouts.app')

@section('title', 'The Lighthouse Cafe - Coastal Fine Dining Experience')

@section('content')
    <!-- Hero Slider -->
    <div x-data="{
        currentSlide: 0,
        slides: [{
                image: 'https://images.unsplash.com/photo-1514326640560-7d063f2aad03?w=1920&h=800&fit=crop',
                title: 'Coastal Elegance',
                subtitle: 'Where Ocean Meets Cuisine',
                cta: 'Reserve Your Table'
            },
            {
                image: 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=1920&h=800&fit=crop',
                title: 'Fine Dining Excellence',
                subtitle: 'Crafted with Passion, Served with Pride',
                cta: 'Explore Menu'
            },
            {
                image: 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=1920&h=800&fit=crop',
                title: 'Fresh from the Sea',
                subtitle: 'Sustainable Seafood Daily',
                cta: 'View Specials'
            }
        ],
        autoplay: null,
        init() {
            this.autoplay = setInterval(() => {
                this.next();
            }, 5000);
        },
        next() {
            this.currentSlide = (this.currentSlide + 1) % this.slides.length;
        },
        prev() {
            this.currentSlide = this.currentSlide === 0 ? this.slides.length - 1 : this.currentSlide - 1;
        }
    }"
        class="relative h-screen overflow-hidden bg-gradient-to-br from-slate-900 via-navy-900 to-slate-800">
        <!-- Slides -->
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="currentSlide === index" x-transition:enter="transition ease-out duration-1000"
                x-transition:enter-start="opacity-0 transform scale-110"
                x-transition:enter-end="opacity-100 transform scale-100" class="absolute inset-0">
                <img :src="slide.image" :alt="slide.title" class="w-full h-full object-cover filter brightness-75">
                <div class="absolute inset-0 bg-gradient-to-r from-slate-900/90 via-slate-800/50 to-slate-900/70"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>

                <!-- Content -->
                <div class="absolute inset-0 flex items-center">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                        <div class="max-w-3xl">
                            <h1 x-text="slide.title"
                                class="text-6xl md:text-8xl font-serif font-extrabold text-amber-400 mb-6 drop-shadow-2xl">
                            </h1>
                            <p x-text="slide.subtitle"
                                class="text-2xl md:text-3xl text-slate-200 mb-10 drop-shadow-lg italic"></p>
                            <a href="{{ route('reservations.create') }}"
                                class="inline-block bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-slate-900 font-bold py-4 px-10 rounded-lg text-xl shadow-2xl transform hover:scale-105 transition-all duration-300">
                                <span x-text="slide.cta"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <!-- Navigation Arrows -->
        <button @click="prev()"
            class="absolute left-6 top-1/2 -translate-y-1/2 bg-slate-800/50 hover:bg-slate-700/70 p-4 rounded-full transition-all duration-300 backdrop-blur-md shadow-lg hover:shadow-xl transform hover:scale-110 border border-amber-500/30">
            <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <button @click="next()"
            class="absolute right-6 top-1/2 -translate-y-1/2 bg-slate-800/50 hover:bg-slate-700/70 p-4 rounded-full transition-all duration-300 backdrop-blur-md shadow-lg hover:shadow-xl transform hover:scale-110 border border-amber-500/30">
            <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>

        <!-- Dots -->
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex space-x-4">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="currentSlide = index"
                    :class="currentSlide === index ? 'bg-amber-500 w-16 shadow-lg' : 'bg-slate-400/60 w-4'"
                    class="h-4 rounded-full transition-all duration-500 hover:scale-125"></button>
            </template>
        </div>
    </div>

    <!-- Featured Dishes of the Day -->
    <section class="py-24 bg-gradient-to-br from-slate-50 via-white to-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" x-data="{ activeTab: 'day' }">
                <h2 class="section-title text-5xl md:text-6xl font-serif font-extrabold text-slate-800 mb-4 drop-shadow-lg">
                    Featured Specialties</h2>
                <p class="section-subtitle text-xl md:text-2xl text-slate-600 mb-12 italic">Handcrafted daily by our
                    award-winning chefs</p>

                <!-- Tabs -->
                <div class="flex justify-center space-x-6 mb-16">
                    <button @click="activeTab = 'day'"
                        :class="activeTab === 'day' ?
                            'bg-gradient-to-r from-amber-500 to-amber-600 text-slate-900 shadow-2xl' :
                            'bg-slate-200 text-slate-700 hover:bg-slate-300'"
                        class="px-10 py-4 rounded-lg font-bold text-lg transition-all duration-300 transform hover:scale-105">
                        Dish of the Day
                    </button>
                    <button @click="activeTab = 'week'"
                        :class="activeTab === 'week' ?
                            'bg-gradient-to-r from-amber-500 to-amber-600 text-slate-900 shadow-2xl' :
                            'bg-slate-200 text-slate-700 hover:bg-slate-300'"
                        class="px-10 py-4 rounded-lg font-bold text-lg transition-all duration-300 transform hover:scale-105">
                        Week's Special
                    </button>
                </div>

                <!-- Featured Day Dishes -->
                <div x-show="activeTab === 'day'" x-transition class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    @forelse($featuredDay ?? [] as $dish)
                        <div
                            class="card group bg-white rounded-2xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-500 overflow-hidden border border-slate-200">
                            <div class="relative overflow-hidden h-72">
                                <img src="{{ $dish->image }}" alt="{{ $dish->name }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                                <div
                                    class="absolute top-6 right-6 bg-gradient-to-r from-amber-400 to-amber-500 text-slate-900 px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                                    ⭐ {{ $dish->rating }}
                                </div>
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-slate-900/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                </div>
                            </div>
                            <div class="p-8">
                                <h3 class="text-3xl font-serif font-bold mb-3 text-slate-800">{{ $dish->name }}</h3>
                                <p class="text-slate-600 mb-6 leading-relaxed">{{ $dish->description }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-4xl font-extrabold text-amber-600">${{ $dish->price }}</span>
                                    <a href="{{ route('menu') }}"
                                        class="text-amber-600 hover:text-amber-700 font-bold text-lg transition-colors duration-300">Order
                                        Now →</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-slate-500 text-xl">No featured dishes available today</div>
                    @endforelse
                </div>

                <!-- Featured Week Dishes -->
                <div x-show="activeTab === 'week'" x-transition class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    @forelse($featuredWeek ?? [] as $dish)
                        <div
                            class="card group bg-white rounded-2xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-500 overflow-hidden border border-slate-200">
                            <div class="relative overflow-hidden h-72">
                                <img src="{{ $dish->image }}" alt="{{ $dish->name }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                                <div
                                    class="absolute top-6 right-6 bg-gradient-to-r from-amber-400 to-amber-500 text-slate-900 px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                                    ⭐ {{ $dish->rating }}
                                </div>
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-slate-900/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                </div>
                            </div>
                            <div class="p-8">
                                <h3 class="text-3xl font-serif font-bold mb-3 text-slate-800">{{ $dish->name }}</h3>
                                <p class="text-slate-600 mb-6 leading-relaxed">{{ $dish->description }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-4xl font-extrabold text-amber-600">${{ $dish->price }}</span>
                                    <a href="{{ route('menu') }}"
                                        class="text-amber-600 hover:text-amber-700 font-bold text-lg transition-colors duration-300">Order
                                        Now →</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-slate-500 text-xl">No featured dishes this week</div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-24 bg-gradient-to-br from-slate-100 via-slate-50 to-amber-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="section-title text-5xl md:text-6xl font-serif font-extrabold text-slate-800 mb-4 drop-shadow-lg">
                    Why The Lighthouse</h2>
                <p class="section-subtitle text-xl md:text-2xl text-slate-600 italic">Excellence in every detail</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div
                    class="bg-white p-10 rounded-2xl shadow-xl text-center hover:shadow-2xl transition-all duration-500 transform hover:scale-105 border border-slate-200 hover:border-amber-300">
                    <div
                        class="w-20 h-20 bg-gradient-to-r from-amber-400 to-amber-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <span class="text-4xl">👨‍🍳</span>
                    </div>
                    <h3 class="text-2xl font-serif font-bold mb-4 text-slate-800">Master Chefs</h3>
                    <p class="text-slate-600 leading-relaxed">Award-winning culinary team with 50+ years combined
                        experience</p>
                </div>

                <div
                    class="bg-white p-10 rounded-2xl shadow-xl text-center hover:shadow-2xl transition-all duration-500 transform hover:scale-105 border border-slate-200 hover:border-amber-300">
                    <div
                        class="w-20 h-20 bg-gradient-to-r from-slate-600 to-slate-700 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <span class="text-4xl">🌊</span>
                    </div>
                    <h3 class="text-2xl font-serif font-bold mb-4 text-slate-800">Fresh Seafood</h3>
                    <p class="text-slate-600 leading-relaxed">Daily catches from local sustainable fisheries</p>
                </div>

                <div
                    class="bg-white p-10 rounded-2xl shadow-xl text-center hover:shadow-2xl transition-all duration-500 transform hover:scale-105 border border-slate-200 hover:border-amber-300">
                    <div
                        class="w-20 h-20 bg-gradient-to-r from-amber-500 to-amber-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <span class="text-4xl">🍷</span>
                    </div>
                    <h3 class="text-2xl font-serif font-bold mb-4 text-slate-800">Premium Wine</h3>
                    <p class="text-slate-600 leading-relaxed">Curated selection of 200+ international wines</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-gradient-to-r from-slate-800 via-slate-900 to-slate-800 text-black relative overflow-hidden">
        <div
            class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSAxMCAwIEwgMCAwIDAgMTAiIGZpbGw9Im5vbmUiIHN0cm9rZT0iIzMzMyIgc3Ryb2tlLXdpZHRoPSIxIi8+PC9wYXR0ZXJuPjwvZGVmcz48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSJ1cmwoI2dyaWQpIi8+PC9zdmc+')] opacity-10">
        </div>
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-5xl md:text-6xl font-serif font-extrabold mb-8 drop-shadow-2xl text-amber-400">Join Our
                Exclusive Club</h2>
            <p class="text-2xl mb-12 text-slate-200 italic drop-shadow-lg">Enjoy exclusive benefits, priority reservations,
                and special member-only events</p>
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <a href="{{ route('membership') }}"
                    class="bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-slate-900 font-bold py-5 px-12 rounded-lg text-xl shadow-2xl transform hover:scale-105 transition-all duration-300">
                    Become a Member
                </a>
                <a href="{{ route('reservations.create') }}"
                    class="bg-transparent border-2 border-amber-400 hover:bg-amber-400 hover:text-slate-900 font-bold py-5 px-12 rounded-lg text-xl shadow-2xl transform hover:scale-105 transition-all duration-300">
                    Reserve a Table
                </a>
            </div>
        </div>
    </section>
@endsection
