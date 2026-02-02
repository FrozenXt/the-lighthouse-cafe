<?php

// app/Http/Controllers/Admin/DishController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dish;
use Illuminate\Http\Request;

class DishController extends Controller
{
    public function index()
    {
        $dishes = Dish::orderBy('category')->orderBy('name')->paginate(20);
        return view('admin.dishes.index', compact('dishes'));
    }

    public function create()
    {
        $categories = ['Appetizers', 'Seafood', 'Steaks & Chops', 'Pasta & Risotto', 'Desserts'];
        return view('admin.dishes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required|url',
            'category' => 'required|string',
            'rating' => 'required|numeric|min:0|max:5',
            'featured_type' => 'required|in:none,day,week'
        ]);

        Dish::create($validated);

        return redirect()->route('admin.dishes.index')
            ->with('success', 'Dish added successfully!');
    }

    public function edit(Dish $dish)
    {
        $categories = ['Appetizers', 'Seafood', 'Steaks & Chops', 'Pasta & Risotto', 'Desserts'];
        return view('admin.dishes.edit', compact('dish', 'categories'));
    }

    public function update(Request $request, Dish $dish)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required|url',
            'category' => 'required|string',
            'rating' => 'required|numeric|min:0|max:5',
            'featured_type' => 'required|in:none,day,week'
        ]);

        $dish->update($validated);

        return redirect()->route('admin.dishes.index')
            ->with('success', 'Dish updated successfully!');
    }

    public function destroy(Dish $dish)
    {
        $dish->delete();
        return redirect()->route('admin.dishes.index')
            ->with('success', 'Dish deleted successfully!');
    }

    public function toggleAvailability(Dish $dish)
    {
        $dish->update(['is_available' => !$dish->is_available]);
        return back()->with('success', 'Availability updated!');
    }
}
