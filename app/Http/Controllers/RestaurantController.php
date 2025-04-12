<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::select('id','name', 'cover_image', 'city', 'description')->get();
        return view('welcome', compact('restaurants'));
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
     * Store a new reservation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeReservation(Request $request)
    {
        $validated = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'table_id' => 'required|exists:tables,id',
            'booking_date' => 'required|date|after:now',
            'booking_time' => 'required',
            'end_time' => 'required',
            'guests_number' => 'required|integer|min:1',
            'special_requests' => 'nullable|string|max:500',
        ]);

        // Combine date and time for booking_date
        $bookingDate = $validated['booking_date'] . ' ' . $validated['booking_time'];
        $bookingDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $bookingDate);

        // Combine date and time for end_time
        $endTime = $validated['booking_date'] . ' ' . $validated['end_time'];
        $endDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $endTime);

        // Prepare reservation data
        $reservationData = [
            'restaurant_id' => $validated['restaurant_id'],
            'table_id' => $validated['table_id'],
            'booking_date' => $bookingDateTime,
            'end_time' => $endDateTime,
            'guests_number' => $validated['guests_number'],
            'special_requests' => $validated['special_requests'] ?? null,
            'user_id' => auth()->id(),
            'status' => 'pending',
        ];

        // Create the reservation
        $reservation = \App\Models\Reservation::create($reservationData);

        return redirect()->route('restaurants.show', $validated['restaurant_id'])
            ->with('success', 'Your reservation has been submitted and is awaiting confirmation.');
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
}
