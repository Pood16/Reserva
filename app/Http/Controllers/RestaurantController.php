<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::select('name', 'cover_image', 'city', 'description')->get();
        return view('welcome', compact('restaurants'));
    }
}
