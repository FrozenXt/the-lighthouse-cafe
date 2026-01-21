<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dish;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Featured Dishes of the Day
        Dish::create([
            'name' => 'Lobster Thermidor',
            'description' => 'Classic French lobster dish with cognac cream sauce, served with seasonal vegetables',
            'price' => 48.00,
            'image' => 'https://images.unsplash.com/photo-1625944525533-473f1a3d54e7?w=800&h=600&fit=crop',
            'featured_type' => 'day',
            'category' => 'Seafood',
            'rating' => 4.9,
        ]);

        Dish::create([
            'name' => 'Pan-Seared Scallops',
            'description' => 'Jumbo scallops with lemon butter sauce, asparagus, and truffle risotto',
            'price' => 38.00,
            'image' => 'https://images.unsplash.com/photo-1559847844-5315695dadae?w=800&h=600&fit=crop',
            'featured_type' => 'day',
            'category' => 'Seafood',
            'rating' => 4.8,
        ]);

        Dish::create([
            'name' => 'Beef Wellington',
            'description' => 'Prime beef tenderloin wrapped in puff pastry with mushroom duxelles',
            'price' => 52.00,
            'image' => 'https://images.unsplash.com/photo-1558030006-450675393462?w=800&h=600&fit=crop',
            'featured_type' => 'day',
            'category' => 'Steaks & Chops',
            'rating' => 4.9,
        ]);

        // Featured Dishes of the Week
        Dish::create([
            'name' => 'Mediterranean Branzino',
            'description' => 'Whole roasted sea bass with herbs, olives, tomatoes, and lemon',
            'price' => 42.00,
            'image' => 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?w=800&h=600&fit=crop',
            'featured_type' => 'week',
            'category' => 'Seafood',
            'rating' => 4.7,
        ]);

        Dish::create([
            'name' => 'Truffle Risotto',
            'description' => 'Creamy Arborio rice with black truffles, parmesan, and wild mushrooms',
            'price' => 32.00,
            'image' => 'https://images.unsplash.com/photo-1476124369491-c4ad9e45e782?w=800&h=600&fit=crop',
            'featured_type' => 'week',
            'category' => 'Pasta & Risotto',
            'rating' => 4.8,
        ]);

        Dish::create([
            'name' => 'Wagyu Ribeye',
            'description' => '12oz Japanese A5 Wagyu with roasted garlic, herb butter, and fingerling potatoes',
            'price' => 68.00,
            'image' => 'https://images.unsplash.com/photo-1600891964092-4316c288032e?w=800&h=600&fit=crop',
            'featured_type' => 'week',
            'category' => 'Steaks & Chops',
            'rating' => 5.0,
        ]);

        // Regular Menu Items - Appetizers
        Dish::create([
            'name' => 'Oysters Rockefeller',
            'description' => 'Fresh oysters baked with spinach, herbs, and parmesan breadcrumbs',
            'price' => 18.00,
            'image' => 'https://images.unsplash.com/photo-1563251958-8b1f4a6cf8f3?w=800&h=600&fit=crop',
            'featured_type' => 'none',
            'category' => 'Appetizers',
            'rating' => 4.6,
        ]);

        Dish::create([
            'name' => 'Tuna Tartare',
            'description' => 'Sushi-grade tuna with avocado, sesame, and crispy wonton chips',
            'price' => 22.00,
            'image' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=800&h=600&fit=crop',
            'featured_type' => 'none',
            'category' => 'Appetizers',
            'rating' => 4.7,
        ]);

        Dish::create([
            'name' => 'Burrata & Heirloom Tomatoes',
            'description' => 'Creamy burrata with fresh basil, aged balsamic, and olive oil',
            'price' => 16.00,
            'image' => 'https://images.unsplash.com/photo-1608897013039-887f21d8c804?w=800&h=600&fit=crop',
            'featured_type' => 'none',
            'category' => 'Appetizers',
            'rating' => 4.5,
        ]);

        // Seafood
        Dish::create([
            'name' => 'Chilean Sea Bass',
            'description' => 'Miso-glazed sea bass with bok choy and jasmine rice',
            'price' => 44.00,
            'image' => 'https://images.unsplash.com/photo-1580959375944-2c6d74d4f571?w=800&h=600&fit=crop',
            'featured_type' => 'none',
            'category' => 'Seafood',
            'rating' => 4.8,
        ]);

        Dish::create([
            'name' => 'Grilled Salmon',
            'description' => 'Wild-caught salmon with dill sauce, roasted vegetables, and quinoa',
            'price' => 34.00,
            'image' => 'https://images.unsplash.com/photo-1467003909585-2f8a72700288?w=800&h=600&fit=crop',
            'featured_type' => 'none',
            'category' => 'Seafood',
            'rating' => 4.6,
        ]);

        // Steaks & Chops
        Dish::create([
            'name' => 'Filet Mignon',
            'description' => '8oz center-cut tenderloin with red wine reduction and mashed potatoes',
            'price' => 46.00,
            'image' => 'https://images.unsplash.com/photo-1546833998-877b37c2e5c6?w=800&h=600&fit=crop',
            'featured_type' => 'none',
            'category' => 'Steaks & Chops',
            'rating' => 4.9,
        ]);

        Dish::create([
            'name' => 'Lamb Chops',
            'description' => 'Herb-crusted New Zealand lamb with mint pesto and roasted root vegetables',
            'price' => 42.00,
            'image' => 'https://images.unsplash.com/photo-1595777216528-071e0127ccf2?w=800&h=600&fit=crop',
            'featured_type' => 'none',
            'category' => 'Steaks & Chops',
            'rating' => 4.7,
        ]);

        // Pasta & Risotto
        Dish::create([
            'name' => 'Lobster Linguine',
            'description' => 'Fresh pasta with lobster, cherry tomatoes, garlic, and white wine',
            'price' => 36.00,
            'image' => 'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?w=800&h=600&fit=crop',
            'featured_type' => 'none',
            'category' => 'Pasta & Risotto',
            'rating' => 4.7,
        ]);

        Dish::create([
            'name' => 'Pappardelle Bolognese',
            'description' => 'Wide ribbon pasta with slow-cooked beef ragu and parmesan',
            'price' => 28.00,
            'image' => 'https://images.unsplash.com/photo-1607532941433-304659e8198a?w=800&h=600&fit=crop',
            'featured_type' => 'none',
            'category' => 'Pasta & Risotto',
            'rating' => 4.6,
        ]);

        // Desserts
        Dish::create([
            'name' => 'Chocolate Lava Cake',
            'description' => 'Warm chocolate cake with molten center, vanilla ice cream, and berries',
            'price' => 12.00,
            'image' => 'https://images.unsplash.com/photo-1606313564200-e75d5e30476c?w=800&h=600&fit=crop',
            'featured_type' => 'none',
            'category' => 'Desserts',
            'rating' => 4.9,
        ]);

        Dish::create([
            'name' => 'Crème Brûlée',
            'description' => 'Classic vanilla custard with caramelized sugar and fresh berries',
            'price' => 10.00,
            'image' => 'https://images.unsplash.com/photo-1470124182917-cc6e71b22ecc?w=800&h=600&fit=crop',
            'featured_type' => 'none',
            'category' => 'Desserts',
            'rating' => 4.8,
        ]);

        Dish::create([
            'name' => 'Tiramisu',
            'description' => 'Italian coffee-soaked ladyfingers with mascarpone and cocoa',
            'price' => 11.00,
            'image' => 'https://images.unsplash.com/photo-1571877227200-a0d98ea607e9?w=800&h=600&fit=crop',
            'featured_type' => 'none',
            'category' => 'Desserts',
            'rating' => 4.7,
        ]);
    }
}