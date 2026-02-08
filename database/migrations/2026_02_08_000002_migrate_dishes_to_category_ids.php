<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Dish;
use App\Models\Category;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get all dishes and map them to categories by name
        $dishes = Dish::all();

        foreach ($dishes as $dish) {
            if (!empty($dish->category)) {
                $categoryName = trim($dish->category);
                $category = Category::where('name', $categoryName)->first();

                if ($category) {
                    $dish->update(['category_id' => $category->id]);
                } else {
                    // If category doesn't exist, create it
                    $newCategory = Category::create([
                        'name' => $categoryName,
                        'display_order' => 99,
                        'is_active' => true
                    ]);
                    $dish->update(['category_id' => $newCategory->id]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reset category_id to null
        DB::table('dishes')->update(['category_id' => null]);
    }
};
