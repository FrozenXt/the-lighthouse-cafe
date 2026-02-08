<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dish;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create categories first
        $this->call(CategorySeeder::class);

        // Disable foreign key checks (safe reset)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Dish::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $dishes = [
            [
                'name' => 'Lobster Thermidor',
                'description' => 'Classic French lobster dish with cognac cream sauce, served with seasonal vegetables',
                'price' => 48.00,
                'image' => 'dishes/lobster-thermidor.jpg',
                'featured_type' => 'day',
                'category' => 'Seafood',
                'rating' => 4.9,
            ],
            [
                'name' => 'Pan-Seared Scallops',
                'description' => 'Jumbo scallops with lemon butter sauce, asparagus, and truffle risotto',
                'price' => 38.00,
                'image' => 'dishes/pan-seared-scallops.jpg',
                'featured_type' => 'day',
                'category' => 'Seafood',
                'rating' => 4.8,
            ],
            [
                'name' => 'Beef Wellington',
                'description' => 'Prime beef tenderloin wrapped in puff pastry with mushroom duxelles',
                'price' => 52.00,
                'image' => 'dishes/beef-wellington.jpg',
                'featured_type' => 'day',
                'category' => 'Steaks & Chops',
                'rating' => 4.9,
            ],
            [
                'name' => 'Mediterranean Branzino',
                'description' => 'Whole roasted sea bass with herbs, olives, tomatoes, and lemon',
                'price' => 42.00,
                'image' => 'dishes/mediterranean-branzino.jpg',
                'featured_type' => 'week',
                'category' => 'Seafood',
                'rating' => 4.7,
            ],
            [
                'name' => 'Truffle Risotto',
                'description' => 'Creamy Arborio rice with black truffles, parmesan, and wild mushrooms',
                'price' => 32.00,
                'image' => 'dishes/truffle-risotto.jpg',
                'featured_type' => 'week',
                'category' => 'Pasta & Risotto',
                'rating' => 4.8,
            ],
            [
                'name' => 'Wagyu Ribeye',
                'description' => '12oz Japanese A5 Wagyu with roasted garlic, herb butter, and fingerling potatoes',
                'price' => 68.00,
                'image' => 'dishes/wagyu-ribeye.jpg',
                'featured_type' => 'week',
                'category' => 'Steaks & Chops',
                'rating' => 5.0,
            ],
            [
                'name' => 'Oysters Rockefeller',
                'description' => 'Fresh oysters baked with spinach, herbs, and parmesan breadcrumbs',
                'price' => 18.00,
                'image' => 'dishes/oysters-rockefeller.jpg',
                'featured_type' => 'none',
                'category' => 'Appetizers',
                'rating' => 4.6,
            ],
            [
                'name' => 'Tuna Tartare',
                'description' => 'Sushi-grade tuna with avocado, sesame, and crispy wonton chips',
                'price' => 22.00,
                'image' => 'dishes/tuna-tartare.png',
                'featured_type' => 'none',
                'category' => 'Appetizers',
                'rating' => 4.7,
            ],
            [
                'name' => 'Chocolate Lava Cake',
                'description' => 'Warm chocolate cake with molten center, vanilla ice cream, and berries',
                'price' => 12.00,
                'image' => 'dishes/chocolate-lava-cake.jpg',
                'featured_type' => 'none',
                'category' => 'Desserts',
                'rating' => 4.9,
            ],
            [
                'name' => 'Crème Brûlée',
                'description' => 'Classic vanilla custard with caramelized sugar and fresh berries',
                'price' => 10.00,
                'image' => 'dishes/creme-brulee.jpg',
                'featured_type' => 'none',
                'category' => 'Desserts',
                'rating' => 4.8,
            ],
        ];

        foreach ($dishes as $dish) {
            Dish::create($dish);
        }
    }
}
