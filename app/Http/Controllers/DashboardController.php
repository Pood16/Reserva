<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the user dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();

        // Get recent reservations
        $reservations = Reservation::where('user_id', $user->id)
            ->with(['restaurant', 'table'])
            ->latest()
            ->take(5)
            ->get();

        // Get favorite restaurants
        $favoriteRestaurants = $user->favoriteRestaurants()
            ->take(4)
            ->get();

        return view('dashboard', compact('user', 'reservations', 'favoriteRestaurants'));
    }
}
