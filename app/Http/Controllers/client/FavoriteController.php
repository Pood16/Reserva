<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()->favoriteRestaurants()->paginate(10);
        return view('client.favorites.index', compact('favorites'));
    }

    public function toggleFavorite(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'User must be logged in to favorite restaurants'], 401);
        }

        $restaurant = Restaurant::findOrFail($id);
        $user = Auth::user();

        // Check if the restaurant is already favorited
        $isFavorited = $user->hasFavorited($restaurant);

        if ($isFavorited) {
            // If already favorited, remove the favorite
            $user->favoriteRestaurants()->detach($restaurant->id);
            $isFavorited = false;
            $message = 'Restaurant removed from favorites';
        } else {
            // If not favorited, add the favorite
            $user->favoriteRestaurants()->attach($restaurant->id);
            $isFavorited = true;
            $message = 'Restaurant added to favorites';
        }

        return response()->json([
            'isFavorited' => $isFavorited,
            'message' => $message,
            'favoriteCount' => $restaurant->favoritedByUsers()->count()
        ]);
    }

    public function checkFavoriteStatus($id)
    {
        if (!Auth::check()) {
            return response()->json(['isFavorited' => false], 200);
        }

        $restaurant = Restaurant::findOrFail($id);
        $isFavorited = Auth::user()->hasFavorited($restaurant);

        return response()->json(['isFavorited' => $isFavorited], 200);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $user->favoriteRestaurants()->detach($id);

        return redirect()->route('favorites.index')->with('success', 'Restaurant removed from favorites');
    }
}
