<?php
// app/Http/Controllers/HomeController.php
namespace App\Http\Controllers;

use App\Models\Dish;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredDay = Dish::where('featured_type', 'day')->get();
        $featuredWeek = Dish::where('featured_type', 'week')->get();
        
        return view('home', compact('featuredDay', 'featuredWeek'));
    }
}