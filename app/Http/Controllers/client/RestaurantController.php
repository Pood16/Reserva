<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\FoodType;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index(Request $request)
    {
        $query = Restaurant::with(['reviews', 'foodTypes', 'images'])->where('is_active', true);
        $foodTypes = FoodType::all();
        $cities = Restaurant::select('city')->distinct()->pluck('city');

        // Search by name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Filter by city
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        // Filter by food type
        if ($request->filled('food_type')) {
            $query->whereHas('foodTypes', function($q) use ($request) {
                $q->where('food_types.id', $request->food_type);
            });
        }

        // Get popular restaurants
        $popularRestaurants = Restaurant::with(['reviews', 'foodTypes', 'images'])
            ->where('is_active', true)
            ->withAvg('reviews', 'rating')
            ->orderBy('reviews_avg_rating', 'desc')
            ->take(3)
            ->get();

        // all restaurants
        $restaurants = $query->get();

        return view('restaurants.explore-restaurants', compact('restaurants', 'popularRestaurants', 'foodTypes', 'cities'));
    }

    public function show(Restaurant $restaurant)
    {
        $restaurant->load(['reviews', 'foodTypes', 'images', 'menus.items', 'openingDays']);
        return view('restaurants.show', compact('restaurant'));
    }

    public function toggleFavorite(Restaurant $restaurant)
    {
        $user = auth()->user();

        if ($user->favorites()->where('restaurant_id', $restaurant->id)->exists()) {
            $user->favorites()->detach($restaurant->id);
            $message = 'Restaurant removed from favorites';
        } else {
            $user->favorites()->attach($restaurant->id);
            $message = 'Restaurant added to favorites';
        }

        return response()->json(['message' => $message]);
    }
}
