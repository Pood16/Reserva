<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the user's favorite restaurants.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $favorites = Auth::user()->favoriteRestaurants()->get();
        return view('favorites.index', compact('favorites'));
    }

    /**
     * Remove the specified restaurant from the user's favorites.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        Auth::user()->favoriteRestaurants()->detach($restaurant->id);

        return redirect()->route('favorites.index')
            ->with('success', 'Restaurant removed from favorites.');
    }
}
