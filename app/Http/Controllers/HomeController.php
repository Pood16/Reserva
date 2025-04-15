<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the welcome/home page with featured restaurants
     */
    public function index()
    {
        // Get featured restaurants - either based on ratings or manually featured
        $restaurants = Restaurant::with('reviews')
            ->withCount('reviews')
            ->orderByDesc(
                \DB::raw('(SELECT AVG(rating) FROM reviews WHERE reviews.restaurant_id = restaurants.id)')
            )
            ->orderByDesc('reviews_count')
            ->take(8)
            ->get();

        return view('welcome', compact('restaurants'));
    }

    /**
     * Display the about us page
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Display the contact page
     */
    public function contact()
    {
        return view('contact');
    }
}
