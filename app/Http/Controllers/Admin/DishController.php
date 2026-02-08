<?php

// app/Http/Controllers/Admin/DishController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dish;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DishController extends Controller
{
    public function index()
    {
        $dishes = Dish::with('category')->orderBy('category_id')->orderBy('name')->paginate(20);
        return view('admin.dishes.index', compact('dishes'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('display_order')->get();
        return view('admin.dishes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120', // 5MB max
            'category_id' => 'required|exists:categories,id',
            'rating' => 'required|numeric|min:0|max:5',
            'featured_type' => 'required|in:none,day,week'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('dishes', 'public');
            $validated['image'] = $imagePath;
        }

        Dish::create($validated);

        return redirect()->route('admin.dishes.index')
            ->with('success', 'Dish added successfully!');
    }

    public function edit(Dish $dish)
    {
        $categories = Category::where('is_active', true)->orderBy('display_order')->get();
        return view('admin.dishes.edit', compact('dish', 'categories'));
    }

    public function update(Request $request, Dish $dish)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // Optional on update
            'category_id' => 'required|exists:categories,id',
            'rating' => 'required|numeric|min:0|max:5',
            'featured_type' => 'required|in:none,day,week'
        ]);

        // Handle image upload if new image provided
        if ($request->hasFile('image')) {
            // Delete old image
            if ($dish->image && Storage::disk('public')->exists($dish->image)) {
                Storage::disk('public')->delete($dish->image);
            }

            // Store new image
            $imagePath = $request->file('image')->store('dishes', 'public');
            $validated['image'] = $imagePath;
        }

        $dish->update($validated);

        return redirect()->route('admin.dishes.index')
            ->with('success', 'Dish updated successfully!');
    }

    public function destroy(Dish $dish)
    {
        // Delete image file
        if ($dish->image && Storage::disk('public')->exists($dish->image)) {
            Storage::disk('public')->delete($dish->image);
        }

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
