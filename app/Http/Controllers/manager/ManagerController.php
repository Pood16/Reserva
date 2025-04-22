<?php


namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Table;
use App\Models\OpeningDay;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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


    public function addRestaurant(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'website' => 'nullable|url|max:255',
            'opening_time' => 'required',
            'closing_time' => 'required',
            'opening_days' => 'required|array',
            'cover_image' => 'nullable|image|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        //  extract opening days
        $openingDays = $validated['opening_days'];
        unset($validated['opening_days']);

        $validated['user_id'] = Auth::id();
        if ($request->hasFile('cover_image')) {
            $validated['cover_image']= $request->file('cover_image')->store('restaurants', 'public');
        } else {
            $validated['cover_image'] = 'default_restaurant.jpg';
        }

        $restaurant = Restaurant::create($validated);
        foreach ($openingDays as $day) {
            OpeningDay::create([
                'restaurant_id' => $restaurant->id,
                'day_of_week' => $day
            ]);
        }
        return redirect()->back()->with('success', 'Restaurant created successfully.');
    }

}
