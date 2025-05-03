<?php


namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Table;
use App\Models\OpeningDay;
use App\Models\RestaurantImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManagerDashboardController extends Controller {

    // Manager Dashboard
    public function dashboard()
    {
        $user = Auth::user();
        $restaurants = Restaurant::where('user_id', $user->id)->get();
        $restaurantCount = $restaurants->count();
        $tableCount = Table::whereIn('restaurant_id', $restaurants->pluck('id'))->count();
        $activeRestaurants = $restaurants->where('is_active', true)->count();

        return view('manager.dashboard', compact(
            'user',
            'restaurants',
            'restaurantCount',
            'tableCount',
            'activeRestaurants'
        ));
    }
}
