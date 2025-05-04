<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{



    public function store(Request $request, Restaurant $restaurant)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:500',
        ]);
        $existingReview = Review::where('user_id', Auth::id())
            ->where('restaurant_id', $restaurant->id)
            ->first();

        if ($existingReview) {
            $existingReview->update([
                'rating' => $validated['rating'],
                'comment' => $validated['comment'],
        ]);
            return redirect()->route('restaurants.show', $restaurant)
                ->with('success', 'Your review has been updated successfully!');
        }

        // Create review
        Review::create([
            'user_id' => Auth::id(),
            'restaurant_id' => $restaurant->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return redirect()->route('restaurants.show', $restaurant)
            ->with('success', 'Your review has been posted successfully!');
    }

    // Delete a review
    public function destroy(Restaurant $restaurant, Review $review)
    {
        // Check if the review belongs to the authenticated user
        if ($review->user_id !== Auth::id()) {
            return redirect()->route('restaurants.show', $restaurant)
                ->with('error', 'You are not authorized to delete this review.');
        }

        $review->delete();

        return redirect()->route('restaurants.show', $restaurant)
            ->with('success', 'Your review has been deleted successfully!');
    }
}
