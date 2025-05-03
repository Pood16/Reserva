<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\ManagerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function index()
    {
        // avg review rating
        $averageRating = DB::table('reviews')->avg('rating');
        // active restaurants
        $activeRestaurantsCount = Restaurant::where('is_active', true)->count();
        // clients
        $clientCount = DB::table('users')->where('role', 'client')->count();
        // cities
        $citiesCount = Restaurant::distinct('city')->count('city');
        return view('index', compact( 'averageRating', 'activeRestaurantsCount', 'clientCount', 'citiesCount'));
    }

    // about page
    public function about()
    {
        return view('pages.about');
    }

    // contact page
    public function contact()
    {
        return view('pages.contact');
    }

    // submit manager request
    public function submitManagerRequest(Request $request)
    {
        $validatedData = $request->validate([
            'FirstName' => 'required|string|max:255',
            'LastName' => 'required|string|max:255',
            'Email' => 'required|email|max:255|unique:manager_requests,Email'
        ]);
        ManagerRequest::create($validatedData);
        return redirect()->route('home')->with('success', 'Your request has been submitted successfully. Our team will review it and contact you via email.');
    }
}
