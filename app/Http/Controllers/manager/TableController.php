<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TableController extends Controller
{

    public function index($restaurantId)
    {
        $restaurant = Restaurant::with('tables')->findOrFail($restaurantId);

        // Check if the authenticated user owns this restaurant
        if ($restaurant->user_id !== Auth::id()) {
            return redirect()->route('manage.restaurants')
                ->with('error', 'You are not authorized to manage tables for this restaurant.');
        }

        return view('manager.tables.index', compact('restaurant'));
    }


    public function store(Request $request, $restaurantId)
    {

        $restaurant = Restaurant::findOrFail($restaurantId);
        if ($restaurant->user_id !== Auth::id()) {
            return redirect()->route('manage.restaurants')->with('error', 'You are not authorized to manage tables for this restaurant.');
        }
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'capacity' => 'required|integer|min:1|max:20',
            'location' => 'required|string|in:indoors,outdoors,terrace',
            'description' => 'nullable|string|max:255',
            'is_available' => 'nullable|string|in:on',
            'is_active' => 'nullable|string|in:on',
        ]);
        $validated['is_available'] = $request->has('is_available') && $request->input('is_available') === 'on';
        $validated['is_active'] = $request->has('is_active') && $request->input('is_active') === 'on';
        $validated['restaurant_id'] = $restaurantId;
        $table = Table::create($validated);
        return redirect()->back()->with('success', 'Table created successfully.');
    }


    public function edit($restaurantId, $id)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);
        if ($restaurant->user_id !== Auth::id()) {
            return redirect()->route('manage.restaurants')
                ->with('error', 'You are not authorized to manage tables for this restaurant.');
        }

        $table = Table::where('restaurant_id', $restaurantId)->findOrFail($id);

        return view('manager.tables.edit', compact('restaurant', 'table'));
    }


    public function update(Request $request, $restaurantId, $id)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);
        if ($restaurant->user_id !== Auth::id()) {
            return redirect()->route('manage.restaurants')
                ->with('error', 'You are not authorized to manage tables for this restaurant.');
        }

        $table = Table::where('restaurant_id', $restaurantId)->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'capacity' => 'required|integer|min:1|max:20',
            'location' => 'required|string|in:indoor,outdoor',
            'description' => 'nullable|string|max:255',
            'is_available' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['is_available'] = $request->has('is_available');
        $validated['is_active'] = $request->has('is_active');

        $table->update($validated);

        return redirect()->route('manager.tables.index', $restaurantId)
            ->with('success', 'Table updated successfully.');
    }


    public function destroy($restaurantId, $id)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);

        if ($restaurant->user_id !== Auth::id()) {
            return redirect()->route('manage.restaurants')
                ->with('error', 'You are not authorized to manage tables for this restaurant.');
        }

        $table = Table::where('restaurant_id', $restaurantId)->findOrFail($id);
        $table->delete();

        return redirect()->route('manager.tables.index', $restaurantId)
            ->with('success', 'Table deleted successfully.');
    }


    public function toggleAvailability($restaurantId, $id)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);

        if ($restaurant->user_id !== Auth::id()) {
            return redirect()->route('manage.restaurants')
                ->with('error', 'You are not authorized to manage tables for this restaurant.');
        }

        $table = Table::where('restaurant_id', $restaurantId)->findOrFail($id);
        $table->is_available = !$table->is_available;
        $table->save();

        return redirect()->route('manager.tables.index', $restaurantId)
            ->with('success', 'Table availability updated successfully.');
    }


    public function toggleActive($restaurantId, $id)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);

        if ($restaurant->user_id !== Auth::id()) {
            return redirect()->route('manage.restaurants')
                ->with('error', 'You are not authorized to manage tables for this restaurant.');
        }

        $table = Table::where('restaurant_id', $restaurantId)->findOrFail($id);
        $table->is_active = !$table->is_active;
        $table->save();

        return redirect()->route('manager.tables.index', $restaurantId)
            ->with('success', 'Table status updated successfully.');
    }
}
