<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Appetizers', 'description' => 'Start your meal with our delicious appetizers', 'display_order' => 1],
            ['name' => 'Pasta', 'description' => 'Traditional and modern pasta dishes', 'display_order' => 2],
            ['name' => 'Seafood', 'description' => 'Fresh catch of the day and premium seafood', 'display_order' => 3],
            ['name' => 'Meat & Poultry', 'description' => 'Premium cuts and poultry selections', 'display_order' => 4],
            ['name' => 'Salads', 'description' => 'Fresh and healthy salad options', 'display_order' => 5],
            ['name' => 'Soups', 'description' => 'Warm and comforting soups', 'display_order' => 6],
            ['name' => 'Beverages', 'description' => 'Hot and cold beverages', 'display_order' => 7],
            ['name' => 'Desserts', 'description' => 'Sweet treats to end your meal', 'display_order' => 8],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                [
                    'description' => $category['description'],
                    'display_order' => $category['display_order'],
                    'is_active' => true,
                ]
            );
        }
    }
}
