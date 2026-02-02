<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Lighthouse Cafe</title>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Inter:wght@300;400;600&display=swap"
        rel="stylesheet">
</head>

<body class="bg-black text-yellow-400 font-[Inter]">

    <!-- Navbar -->
    <header class="fixed w-full z-50 bg-black/80 backdrop-blur border-b border-yellow-500/20">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold tracking-wide font-[Playfair_Display]">The Lighthouse Cafe</h1>
            <nav class="space-x-8 hidden md:block">
                <a href="#" class="hover:text-white transition">Home</a>
                <a href="#menu" class="hover:text-white transition">Menu</a>
                <a href="#featured" class="hover:text-white transition">Featured</a>
                <a href="#" class="hover:text-white transition">Contact</a>
            </nav>
            <button
                class="bg-yellow-400 text-black px-5 py-2 rounded-full font-semibold hover:bg-yellow-300 transition">
                Become a Member
            </button>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="h-screen flex items-center justify-center relative overflow-hidden">
        <div class="absolute inset-0 bg-linear-to-b from-black via-black/70 to-black"></div>

        <div class="relative z-10 text-center max-w-3xl px-6">
            <h2 class="text-5xl md:text-6xl font-bold mb-6 font-[Playfair_Display]">
                Where Flavor Meets the Sea
            </h2>
            <p class="text-lg text-yellow-200 mb-8">
                Experience handcrafted dishes, ocean-inspired ambience, and unforgettable moments.
            </p>
            <div class="flex justify-center gap-6">
                <button
                    class="bg-yellow-400 text-black px-8 py-3 rounded-full font-semibold hover:bg-yellow-300 transition">
                    Explore Menu
                </button>
                <button
                    class="border border-yellow-400 px-8 py-3 rounded-full hover:bg-yellow-400 hover:text-black transition">
                    Featured Dishes
                </button>
            </div>
        </div>
    </section>

    <!-- Featured Slider -->
    <section id="featured" class="py-24 bg-black">
        <div class="max-w-7xl mx-auto px-6">
            <h3 class="text-4xl font-bold mb-14 text-center font-[Playfair_Display]">
                Featured Dishes
            </h3>

            <div class="grid md:grid-cols-3 gap-10">
                <!-- Dish Card -->
                <div class="bg-yellow-400 text-black rounded-2xl overflow-hidden shadow-xl">
                    <img src="https://images.unsplash.com/photo-1551218808-94e220e084d2"
                        class="h-56 w-full object-cover">
                    <div class="p-6">
                        <span class="text-sm font-semibold uppercase">Dish of the Day</span>
                        <h4 class="text-2xl font-bold mt-2">Grilled Salmon Delight</h4>
                        <p class="mt-3 text-sm">Fresh Atlantic salmon, lemon butter sauce, seasonal greens.</p>
                    </div>
                </div>

                <div class="bg-yellow-400 text-black rounded-2xl overflow-hidden shadow-xl">
                    <img src="https://images.unsplash.com/photo-1540189549336-e6e99c3679fe"
                        class="h-56 w-full object-cover">
                    <div class="p-6">
                        <span class="text-sm font-semibold uppercase">Dish of the Week</span>
                        <h4 class="text-2xl font-bold mt-2">Seafood Pasta</h4>
                        <p class="mt-3 text-sm">Creamy garlic sauce, shrimp, calamari & handmade pasta.</p>
                    </div>
                </div>

                <div class="bg-yellow-400 text-black rounded-2xl overflow-hidden shadow-xl">
                    <img src="https://images.unsplash.com/photo-1604908554025-e477d44c15f6"
                        class="h-56 w-full object-cover">
                    <div class="p-6">
                        <span class="text-sm font-semibold uppercase">Chef’s Special</span>
                        <h4 class="text-2xl font-bold mt-2">Lighthouse Steak</h4>
                        <p class="mt-3 text-sm">Premium beef steak, signature spices, roasted potatoes.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Membership Section -->
    <section class="py-24 bg-yellow-400 text-black">
        <div class="max-w-5xl mx-auto px-6 text-center">
            <h3 class="text-4xl font-bold mb-6 font-[Playfair_Display]">Become a Member</h3>
            <p class="mb-10 text-lg">
                Exclusive offers, priority reservations, and early access to special menus.
            </p>
            <button class="bg-black text-yellow-400 px-10 py-4 rounded-full font-semibold hover:bg-gray-900 transition">
                Join Now
            </button>
        </div>
    </section>


    <!-- Footer -->
    <footer class="py-10 bg-black text-center text-sm text-yellow-500">
        © {{ date('Y') }} The Lighthouse Cafe. All rights reserved.
    </footer>

</body>

</html>
