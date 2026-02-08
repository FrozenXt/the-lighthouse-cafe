<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        // Get active categories with their available dishes
        $dishes = Category::where('is_active', true)
            ->orderBy('display_order')
            ->with(['dishes' => function ($query) {
                $query->where('is_available', true)->orderBy('name');
            }])
            ->get()
            ->mapWithKeys(fn($category) => [$category->name => $category->dishes]);

        return view('menu.index', compact('dishes'));
    }

    public function category($category)
    {
        $dishes = Dish::whereHas('category', fn($query) => $query->where('name', $category))
            ->where('is_available', true)
            ->get();

        return view('menu.category', compact('dishes', 'category'));
    }
}
