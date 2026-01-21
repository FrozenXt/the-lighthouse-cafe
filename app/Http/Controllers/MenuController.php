<?php
namespace App\Http\Controllers;

use App\Models\Dish;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $dishes = Dish::where('is_available', true)
                     ->orderBy('category')
                     ->get()
                     ->groupBy('category');
        
        return view('menu.index', compact('dishes'));
    }

    public function category($category)
    {
        $dishes = Dish::where('category', $category)
                     ->where('is_available', true)
                     ->get();
        
        return view('menu.category', compact('dishes', 'category'));
    }
}