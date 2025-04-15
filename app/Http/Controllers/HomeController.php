<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage with featured restaurants
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

        return view('index', compact('restaurants'));
    }

    /**
     * Display the about us page
     */
    public function about()
    {
        return view('pages.about');
    }

    /**
     * Display the contact page
     */
    public function contact()
    {
        return view('pages.contact');
    }
}
