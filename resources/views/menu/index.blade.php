<think>
First, the user wants me to enhance the menu page template, making it stylish and eye-catching, similar to the previous enhancement.

</think>```blade
@extends('layouts.app')

@section('title', 'Menu - The Lighthouse Cafe')

@section('content')
<!-- Hero Section -->
<div class="relative h-screen bg-cover bg-center overflow-hidden" style="background-image: url('https://images.unsplash.com/photo-1544025162-d76694265947?w=1920&h=600&fit=crop');">
    <div class="absolute inset-0 bg-linear-to-br from-black/70 via-teal-900/60 to-blue-900/70"></div>
    <div class="absolute inset-0 bg-linear-to-t from-black/50 to-transparent"></div>
    <div class="relative h-full flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white text-center">
            <h1 class="text-6xl md:text-8xl font-serif font-extrabold mb-6 drop-shadow-2xl animate-pulse">Our Menu</h1>
            <p class="text-2xl md:text-3xl text-gray-100 italic drop-shadow-lg">Culinary excellence in every dish</p>
            <div class="mt-10">
                <a href="#menu" class="inline-block bg-linear-to-r from-yellow-400 to-orange-500 hover:from-yellow-500 hover:to-orange-600 text-black font-bold py-4 px-10 rounded-full text-xl shadow-2xl transform hover:scale-110 transition-all duration-300 animate-bounce">
                    Explore Menu
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Menu Categories -->
<section id="menu" class="py-24 bg-linear-to-br from-gray-100 via-white to-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ activeCategory: 'all' }">
        
        <!-- Category Filter -->
        <div class="flex flex-wrap justify-center gap-6 mb-16">
            <button @click="activeCategory = 'all'" 
                    :class="activeCategory === 'all' ? 'bg-linear-to-r from-teal-500 to-blue-600 text-white shadow-2xl' : 'bg-gray-300 text-gray-700 hover:bg-gray-400'"
                    class="px-8 py-4 rounded-full font-bold text-lg transition-all duration-300 transform hover:scale-105">
                All Menu
            </button>
            @foreach($dishes as $category => $items)
            <button @click="activeCategory = '{{ strtolower($category) }}'" 
                    :class="activeCategory === '{{ strtolower($category) }}' ? 'bg-linear-to-r from-teal-500 to-blue-600 text-white shadow-2xl' : 'bg-gray-300 text-gray-700 hover:bg-gray-400'"
                    class="px-8 py-4 rounded-full font-bold text-lg transition-all duration-300 transform hover:scale-105">
                {{ $category }} ({{ count($items) }})
            </button>
            @endforeach
        </div>

        <!-- Menu Items -->
        @foreach($dishes as $category => $items)
        <div x-show="activeCategory === 'all' || activeCategory === '{{ strtolower($category) }}'" 
             x-transition:enter="transition ease-out duration-700"
             x-transition:enter-start="opacity-0 transform translate-y-10"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             class="mb-20">
            <h2 class="text-5xl md:text-6xl font-serif font-extrabold text-gray-800 mb-12 pb-6 border-b-4 border-gradient-to-r from-teal-500 to-blue-600 drop-shadow-lg text-center">
                {{ $category }}
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($items as $dish)
                <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-500 overflow-hidden group">
                    <div class="relative overflow-hidden h-64">
                        <img src="{{ $dish->image }}" alt="{{ $dish->name }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute top-4 right-4 bg-linear-to-r from-yellow-400 to-orange-500 text-white px-3 py-1 rounded-full text-sm font-bold shadow-lg animate-pulse">
                            ⭐ {{ $dish->rating }}
                        </div>
                        <div class="absolute inset-0 bg-linear-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                    <div class="p-8">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-2xl font-serif font-bold text-gray-900 group-hover:text-teal-600 transition-colors duration-300">
                                {{ $dish->name }}
                            </h3>
                            <span class="text-3xl font-extrabold text-teal-600">${{ number_format($dish->price, 2) }}</span>
                        </div>
                        <p class="text-gray-600 mb-6 leading-relaxed">{{ $dish->description }}</p>
                        <div class="flex items-center justify-between">
                            <div class="flex text-yellow-500">
                                @for($i = 0; $i < floor($dish->rating); $i++)
                                ⭐
                                @endfor
                            </div>
                            <a href="#" class="text-teal-600 hover:text-teal-700 font-bold text-lg transition-colors duration-300">Order Now →</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- Download Menu CTA -->
<section class="py-24 bg-linear-to-r from-teal-600 via-blue-700 to-indigo-800 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="absolute inset-0 bg-linear-to-br from-transparent via-transparent to-black/30"></div>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <h2 class="text-5xl md:text-6xl font-serif font-extrabold mb-8 drop-shadow-2xl animate-pulse">Download Our Full Menu</h2>
        <p class="text-2xl mb-12 text-teal-100 italic drop-shadow-lg">Including wine list, seasonal specials, and chef's recommendations</p>
        <button class="bg-linear-to-r from-yellow-400 to-orange-500 hover:from-yellow-500 hover:to-orange-600 text-black font-bold py-5 px-12 rounded-full text-xl shadow-2xl transform hover:scale-110 transition-all duration-300 animate-bounce">
            Download PDF Menu
        </button>
    </div>
</section>
@endsection
```