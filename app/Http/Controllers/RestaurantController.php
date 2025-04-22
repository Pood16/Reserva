<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{



    public function dashboard()
    {
        $user = Auth::user();
        $restaurants = Restaurant::where('user_id', $user->id)->get();
        $restaurantCount = $restaurants->count();
        $tableCount = Table::whereIn('restaurant_id', $restaurants->pluck('id'))->count();

        // You could add more statistics here as needed
        $activeRestaurants = $restaurants->where('is_active', true)->count();

        return view('manager.dashboard', compact(
            'user',
            'restaurants',
            'restaurantCount',
            'tableCount',
            'activeRestaurants'
        ));
    }

    public function index(Request $request)
    {
        $query = Restaurant::select('id','name', 'cover_image', 'city', 'description');
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }
        $restaurants = $query->get();
        return view('restaurants.explore-restaurants', compact('restaurants'));
    }

    /**
     * Display the specified restaurant details.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $restaurant = Restaurant::with(['reviews', 'images', 'tables'])->findOrFail($id);

        // Calculate average rating
        $avgRating = $restaurant->reviews->avg('rating') ?? 0;

        // Format opening days for display
        $openingDays = is_array($restaurant->opening_days) ?
            implode(', ', $restaurant->opening_days) :
            $restaurant->opening_days;

        // Check if the restaurant is favorited by the logged-in user
        $isFavorited = false;
        if (auth()->check()) {
            $isFavorited = auth()->user()->hasFavorited($restaurant);
        }

        // Get the total number of favorites for this restaurant
        $favoritesCount = $restaurant->favoritedByUsers()->count();

        return view('restaurants.show', compact('restaurant', 'avgRating', 'openingDays', 'isFavorited', 'favoritesCount'));
    }

    /**
     * Toggle the favorite status of a restaurant for the authenticated user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleFavorite($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'User must be logged in to favorite restaurants'], 401);
        }

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

    /**
     * Display a listing of the restaurants owned by the current user.
     *
     * @return \Illuminate\View\View
     */
    public function ownerIndex()
    {
        $restaurants = Restaurant::where('user_id', Auth::id())->get();
        return view('restaurant_owner.restaurants.index', compact('restaurants'));
    }

    /**
     * Show the form for creating a new restaurant.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('restaurant_owner.restaurants.create');
    }

    /**
     * Store a newly created restaurant in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
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
        ]);

        // Add user_id to data
        $validated['user_id'] = Auth::id();

        // Handle cover image if uploaded
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('restaurants', 'public');
            $validated['cover_image'] = $path;
        } else {
            $validated['cover_image'] = 'default_restaurant.jpg';
        }

        // Set is_active to true by default
        $validated['is_active'] = true;

        $restaurant = Restaurant::create($validated);

        return redirect()->route('restaurant_owner.restaurants.index')
            ->with('success', 'Restaurant created successfully.');
    }

    /**
     * Show the form for editing the specified restaurant.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $restaurant = Restaurant::where('user_id', Auth::id())->findOrFail($id);
        return view('restaurant_owner.restaurants.edit', compact('restaurant'));
    }

    /**
     * Update the specified restaurant in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $restaurant = Restaurant::where('user_id', Auth::id())->findOrFail($id);

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
            'is_active' => 'boolean',
        ]);

        // Handle cover image if uploaded
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('restaurants', 'public');
            $validated['cover_image'] = $path;
        }

        $restaurant->update($validated);

        return redirect()->route('restaurant_owner.restaurants.index')
            ->with('success', 'Restaurant updated successfully.');
    }

    /**
     * Display a listing of tables for the restaurant owner.
     *
     * @return \Illuminate\View\View
     */
    public function tableIndex()
    {
        $restaurants = Restaurant::where('user_id', Auth::id())->with('tables')->get();
        return view('restaurant_owner.tables.index', compact('restaurants'));
    }

    /**
     * Show the form for creating a new table.
     *
     * @return \Illuminate\View\View
     */
    public function tableCreate()
    {
        $restaurants = Restaurant::where('user_id', Auth::id())->get();
        return view('restaurant_owner.tables.create', compact('restaurants'));
    }

    /**
     * Store a newly created table in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function tableStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'restaurant_id' => 'required|exists:restaurants,id',
            'capacity' => 'required|integer|min:1|max:20',
            'location' => 'required|string|in:indoors,outdoors',
            'is_active' => 'boolean',
        ]);

        // Verify the restaurant belongs to the authenticated user
        $restaurant = Restaurant::where('id', $validated['restaurant_id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        Table::create($validated);

        return redirect()->route('restaurant_owner.tables.index')
            ->with('success', 'Table created successfully.');
    }

    /**
     * Show the form for editing the specified table.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function tableEdit($id)
    {
        $table = Table::whereHas('restaurant', function($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        $restaurants = Restaurant::where('user_id', Auth::id())->get();

        return view('restaurant_owner.tables.edit', compact('table', 'restaurants'));
    }

    /**
     * Update the specified table in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function tableUpdate(Request $request, $id)
    {
        $table = Table::whereHas('restaurant', function($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'restaurant_id' => 'required|exists:restaurants,id',
            'capacity' => 'required|integer|min:1|max:20',
            'location' => 'required|string|in:indoors,outdoors',
            'is_active' => 'boolean',
        ]);

        // Verify the restaurant belongs to the authenticated user
        Restaurant::where('id', $validated['restaurant_id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $table->update($validated);

        return redirect()->route('restaurant_owner.tables.index')
            ->with('success', 'Table updated successfully.');
    }

    /**
     * Remove the specified table from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function tableDestroy($id)
    {
        $table = Table::whereHas('restaurant', function($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        $table->delete();

        return redirect()->route('restaurant_owner.tables.index')
            ->with('success', 'Table deleted successfully.');
    }
}
