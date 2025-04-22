<?php


namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Table;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller {

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

    public function restaurantsList(){

        $myRestaurants = Restaurant::where('user_id', Auth::id())->get();
        return view('manager.restaurants', compact('myRestaurants'));
    }


}
