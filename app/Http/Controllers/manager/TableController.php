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
    /**
     * Display a listing of the tables for a specific restaurant.
     *
     * @param  int  $restaurantId
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Store a newly created table in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $restaurantId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $restaurantId)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);

        // Check if the authenticated user owns this restaurant
        if ($restaurant->user_id !== Auth::id()) {
            return redirect()->route('manage.restaurants')
                ->with('error', 'You are not authorized to manage tables for this restaurant.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'capacity' => 'required|integer|min:1|max:20',
            'location' => 'required|string|in:indoor,outdoor',
            'description' => 'nullable|string|max:255',
            'is_available' => 'boolean',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('manager.tables.index', $restaurantId)
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'There was a problem with your submission. Please check the form.');
        }

        $validated = $validator->validated();

        // Set default values for checkboxes if not present in request
        $validated['is_available'] = $request->has('is_available');
        $validated['is_active'] = $request->has('is_active');
        $validated['restaurant_id'] = $restaurantId;

        Table::create($validated);

        return redirect()->route('manager.tables.index', $restaurantId)
            ->with('success', 'Table created successfully.');
    }

    /**
     * Show the form for editing the specified table.
     *
     * @param  int  $restaurantId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($restaurantId, $id)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);

        // Check if the authenticated user owns this restaurant
        if ($restaurant->user_id !== Auth::id()) {
            return redirect()->route('manage.restaurants')
                ->with('error', 'You are not authorized to manage tables for this restaurant.');
        }

        $table = Table::where('restaurant_id', $restaurantId)->findOrFail($id);

        return view('manager.tables.edit', compact('restaurant', 'table'));
    }

    /**
     * Update the specified table in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $restaurantId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $restaurantId, $id)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);

        // Check if the authenticated user owns this restaurant
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

        // Set default values for checkboxes if not present in request
        $validated['is_available'] = $request->has('is_available');
        $validated['is_active'] = $request->has('is_active');

        $table->update($validated);

        return redirect()->route('manager.tables.index', $restaurantId)
            ->with('success', 'Table updated successfully.');
    }

    /**
     * Remove the specified table from storage.
     *
     * @param  int  $restaurantId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($restaurantId, $id)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);

        // Check if the authenticated user owns this restaurant
        if ($restaurant->user_id !== Auth::id()) {
            return redirect()->route('manage.restaurants')
                ->with('error', 'You are not authorized to manage tables for this restaurant.');
        }

        $table = Table::where('restaurant_id', $restaurantId)->findOrFail($id);
        $table->delete();

        return redirect()->route('manager.tables.index', $restaurantId)
            ->with('success', 'Table deleted successfully.');
    }

    /**
     * Toggle the availability status of a table.
     *
     * @param  int  $restaurantId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggleAvailability($restaurantId, $id)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);

        // Check if the authenticated user owns this restaurant
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

    /**
     * Toggle the active status of a table.
     *
     * @param  int  $restaurantId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toggleActive($restaurantId, $id)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);

        // Check if the authenticated user owns this restaurant
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
