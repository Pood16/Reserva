<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\ManagerRequest;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage with featured restaurants
     */
    public function index()
    {
        // Get featured restaurants - either based on ratings or manually featured
        $restaurants = Restaurant::with('reviews')
            ->withCount('reviews')
            ->orderByDesc(\DB::raw('(SELECT AVG(rating) FROM reviews WHERE reviews.restaurant_id = restaurants.id)'))
            ->orderByDesc('reviews_count')
            ->take(8)
            ->get();
        return view('index', compact('restaurants'));
    }

    /**
     * Display the about us page
     */
    public function about()
    {
        return view('pages.about');
    }

    /**
     * Display the contact page
     */
    public function contact()
    {
        return view('pages.contact');
    }

    /**
     * Handle manager request submissions
     */
    public function submitManagerRequest(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'FirstName' => 'required|string|max:255',
            'LastName' => 'required|string|max:255',
            'Email' => 'required|email|max:255|unique:manager_requests,Email'
        ]);

        // Create the manager request
        ManagerRequest::create($validatedData);

        // Return success response for AJAX request
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        // For non-AJAX requests, redirect with success message
        return redirect()->route('home')->with('success', 'Your request has been submitted successfully. Our team will review it and contact you via email.');
    }
}
