
@extends('layouts.app')

@section('title', 'The Lighthouse Cafe - Coastal Fine Dining Experience')

@section('content')
<!-- Hero Slider -->
<div x-data="{ 
    currentSlide: 0, 
    slides: [
        {
            image: 'https://images.search.yahoo.com/images/view;_ylt=Awr91ZHqxG9poGcJxi.JzbkF;_ylu=c2VjA3NyBHNsawNpbWcEb2lkAzZiOTdmZjA4MzgxMWUwYzJkZDljM2RiNzU0MTc4MjYzBGdwb3MDMzAEaXQDYmluZw--?back=https%3A%2F%2Fimages.search.yahoo.com%2Fsearch%2Fimages%3Fp%3Drestaurants%26type%3DE210US714G0%26fr%3Dmcafee%26fr2%3Dpiv-web%26tab%3Dorganic%26ri%3D30&w=2048&h=1365&imgurl=media.timeout.com%2Fimages%2F103012873%2Fimage.jpg&rurl=https%3A%2F%2Fwww.timeout.com%2Fnewyork%2Frestaurants%2F100-best-new-york-restaurants&size=3490KB&p=restaurants&oid=6b97ff083811e0c2dd9c3db754178263&fr2=piv-web&fr=mcafee&tt=100+best+restaurants+in+NYC%2C+serving+Italian%2C+Mexican+and+sushi&b=0&ni=21&no=30&ts=&tab=organic&sigr=ETpZ5sJG9ZBg&sigb=m2JibCfo8Itd&sigi=DeozOaw8_HLL&sigt=HP7FC6qALhcf&.crumb=0SBcRDEyjCl&fr=mcafee&fr2=piv-web&type=E210US714G0',
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
}" class="relative h-screen overflow-hidden bg-llinear-to-br from-blue-900 via-teal-800 to-green-900">
    <!-- Slides -->
    <template x-for="(slide, index) in slides" :key="index">
        <div x-show="currentSlide === index" 
             x-transition:enter="transition ease-out duration-1000"
             x-transition:enter-start="opacity-0 transform scale-110 rotate-1"
             x-transition:enter-end="opacity-100 transform scale-100 rotate-0"
             class="absolute inset-0">
            <img :src="slide.image" :alt="slide.title" class="w-full h-full object-cover filter brightness-75 contrast-110">
            <div class="absolute inset-0 bg-linear-to-r from-black/80 via-transparent to-black/60"></div>
            <div class="absolute inset-0 bg-linear-to-t from-black/50 to-transparent"></div>
            
            <!-- Content -->
            <div class="absolute inset-0 flex items-center">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                    <div class="max-w-3xl">
                        <h1 x-text="slide.title" class="text-6xl md:text-8xl font-serif font-extrabold text-white mb-6 drop-shadow-2xl animate-pulse"></h1>
                        <p x-text="slide.subtitle" class="text-2xl md:text-3xl text-gray-100 mb-10 drop-shadow-lg italic"></p>
                        <a href="{{ route('reservations.create') }}" class="inline-block bg-linear-to-r from-yellow-400 to-orange-500 hover:from-yellow-500 hover:to-orange-600 text-black font-bold py-4 px-10 rounded-full text-xl shadow-2xl transform hover:scale-110 transition-all duration-300 animate-bounce">
                            <span x-text="slide.cta"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <!-- Navigation Arrows -->
    <button @click="prev()" class="absolute left-6 top-1/2 -translate-y-1/2 bg-white/30 hover:bg-white/50 p-4 rounded-full transition-all duration-300 backdrop-blur-md shadow-lg hover:shadow-xl transform hover:scale-110">
        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </button>
    <button @click="next()" class="absolute right-6 top-1/2 -translate-y-1/2 bg-white/30 hover:bg-white/50 p-4 rounded-full transition-all duration-300 backdrop-blur-md shadow-lg hover:shadow-xl transform hover:scale-110">
        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>

    <!-- Dots -->
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex space-x-4">
        <template x-for="(slide, index) in slides" :key="index">
            <button @click="currentSlide = index" 
                    :class="currentSlide === index ? 'bg-linear-to-r from-yellow-400 to-orange-500 w-16 shadow-lg' : 'bg-white/60 w-4'"
                    class="h-4 rounded-full transition-all duration-500 hover:scale-125"></button>
        </template>
    </div>
</div>

<!-- Featured Dishes of the Day -->
<section class="py-24 bg-linear-to-br from-gray-100 via-white to-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" x-data="{ activeTab: 'day' }">
            <h2 class="section-title text-5xl md:text-6xl font-serif font-extrabold text-gray-800 mb-4 drop-shadow-lg">Featured Specialties</h2>
            <p class="section-subtitle text-xl md:text-2xl text-gray-600 mb-12 italic">Handcrafted daily by our award-winning chefs</p>
            
            <!-- Tabs -->
            <div class="flex justify-center space-x-6 mb-16">
                <button @click="activeTab = 'day'" 
                        :class="activeTab === 'day' ? 'bg-linear-to-r from-teal-500 to-blue-600 text-white shadow-2xl' : 'bg-gray-300 text-gray-700 hover:bg-gray-400'"
                        class="px-10 py-4 rounded-full font-bold text-lg transition-all duration-300 transform hover:scale-105">
                    Dish of the Day
                </button>
                <button @click="activeTab = 'week'" 
                        :class="activeTab === 'week' ? 'bg-linear-to-r from-teal-500 to-blue-600 text-white shadow-2xl' : 'bg-gray-300 text-gray-700 hover:bg-gray-400'"
                        class="px-10 py-4 rounded-full font-bold text-lg transition-all duration-300 transform hover:scale-105">
                    Week's Special
                </button>
            </div>

            <!-- Featured Day Dishes -->
            <div x-show="activeTab === 'day'" x-transition class="grid grid-cols-1 md:grid-cols-3 gap-10">
                @forelse($featuredDay ?? [] as $dish)
                <div class="card group bg-white rounded-2xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-500 overflow-hidden">
                    <div class="relative overflow-hidden h-72">
                        <img src="{{ $dish->image }}" alt="{{ $dish->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute top-6 right-6 bg-linear-to-r from-yellow-400 to-orange-500 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg animate-pulse">
                            ⭐ {{ $dish->rating }}
                        </div>
                        <div class="absolute inset-0 bg-linear-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                    <div class="p-8">
                        <h3 class="text-3xl font-serif font-bold mb-3 text-gray-800">{{ $dish->name }}</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">{{ $dish->description }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-4xl font-extrabold text-teal-600">${{ $dish->price }}</span>
                            <a href="{{ route('menu') }}" class="text-teal-600 hover:text-teal-700 font-bold text-lg transition-colors duration-300">Order Now →</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-gray-500 text-xl">No featured dishes available today</div>
                @endforelse
            </div>

            <!-- Featured Week Dishes -->
            <div x-show="activeTab === 'week'" x-transition class="grid grid-cols-1 md:grid-cols-3 gap-10">
                @forelse($featuredWeek ?? [] as $dish)
                <div class="card group bg-white rounded-2xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-500 overflow-hidden">
                    <div class="relative overflow-hidden h-72">
                        <img src="{{ $dish->image }}" alt="{{ $dish->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute top-6 right-6 bg-linear-to-r from-yellow-400 to-orange-500 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg animate-pulse">
                            ⭐ {{ $dish->rating }}
                        </div>
                        <div class="absolute inset-0 bg-linear-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                    <div class="p-8">
                        <h3 class="text-3xl font-serif font-bold mb-3 text-gray-800">{{ $dish->name }}</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">{{ $dish->description }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-4xl font-extrabold text-teal-600">${{ $dish->price }}</span>
                            <a href="{{ route('menu') }}" class="text-teal-600 hover:text-teal-700 font-bold text-lg transition-colors duration-300">Order Now →</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-gray-500 text-xl">No featured dishes this week</div>
                @endforelse
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-24 bg-linear-to-br from-teal-50 via-blue-50 to-green-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="section-title text-5xl md:text-6xl font-serif font-extrabold text-gray-800 mb-4 drop-shadow-lg">Why The Lighthouse</h2>
            <p class="section-subtitle text-xl md:text-2xl text-gray-600 italic">Excellence in every detail</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <div class="bg-white p-10 rounded-2xl shadow-xl text-center hover:shadow-2xl transition-all duration-500 transform hover:scale-105 hover:rotate-1">
                <div class="w-20 h-20 bg-linear-to-r from-teal-400 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <span class="text-4xl">👨‍🍳</span>
                </div>
                <h3 class="text-2xl font-serif font-bold mb-4 text-gray-800">Master Chefs</h3>
                <p class="text-gray-600 leading-relaxed">Award-winning culinary team with 50+ years combined experience</p>
            </div>
            
            <div class="bg-white p-10 rounded-2xl shadow-xl text-center hover:shadow-2xl transition-all duration-500 transform hover:scale-105 hover:-rotate-1">
                <div class="w-20 h-20 bg-linear-to-r from-blue-400 to-teal-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <span class="text-4xl">🌊</span>
                </div>
                <h3 class="text-2xl font-serif font-bold mb-4 text-gray-800">Fresh Seafood</h3>
                <p class="text-gray-600 leading-relaxed">Daily catches from local sustainable fisheries</p>
            </div>
            
            <div class="bg-white p-10 rounded-2xl shadow-xl text-center hover:shadow-2xl transition-all duration-500 transform hover:scale-105 hover:rotate-1">
                <div class="w-20 h-20 bg-linear-to-r from-green-400 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <span class="text-4xl">🍷</span>
                </div>
                <h3 class="text-2xl font-serif font-bold mb-4 text-gray-800">Premium Wine</h3>
                <p class="text-gray-600 leading-relaxed">Curated selection of 200+ international wines</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-24 bg-linear-to-r from-teal-600 via-blue-700 to-indigo-800 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="absolute inset-0 bg-linear-to-br from-transparent via-transparent to-black/30"></div>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h2 class="text-5xl md:text-6xl font-serif font-extrabold mb-8 drop-shadow-2xl animate-pulse">Join Our Exclusive Club</h2>
        <p class="text-2xl mb-12 text-teal-100 italic drop-shadow-lg">Enjoy exclusive benefits, priority reservations, and special member-only events</p>
        <div class="flex flex-col sm:flex-row gap-6 justify-center">
            <a href="{{ route('membership') }}" class="bg-linear-to-r from-yellow-400 to-orange-500 hover:from-yellow-500 hover:to-orange-600 text-black font-bold py-5 px-12 rounded-full text-xl shadow-2xl transform hover:scale-110 transition-all duration-300 animate-bounce">
                Become a Member
            </a>
            <a href="{{ route('reservations.create') }}" class="bg-transparent border-2 border-white hover:bg-white hover:text-teal-700 font-bold py-5 px-12 rounded-full text-xl shadow-2xl transform hover:scale-110 transition-all duration-300">
                Reserve a Table
            </a>
        </div>
    </div>
</section>
@endsection
```