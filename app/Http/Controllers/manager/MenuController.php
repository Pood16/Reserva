<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\FoodType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    // List my menus
    public function index($restaurantId)
    {
        $restaurant = Restaurant::where('id', $restaurantId)
            ->where('user_id', Auth::id())
            ->with('menus.items.foodType')
            ->firstOrFail();

        return view('manager.menus.index', compact('restaurant'));
    }

    // Show create menu
    public function create($restaurantId)
    {
        $restaurant = Restaurant::where('id', $restaurantId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('manager.menus.create', compact('restaurant'));
    }

    // Store a new menu
    public function store(Request $request, $restaurantId)
    {
        $restaurant = Restaurant::where('id', $restaurantId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $validated['restaurant_id'] = $restaurant->id;

        Menu::create($validated);

        return redirect()->route('manager.menus.index', $restaurant->id)
            ->with('success', 'Menu created successfully.');
    }

    // Show edit menu
    public function edit($restaurantId, $menuId)
    {
        $restaurant = Restaurant::where('id', $restaurantId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $menu = Menu::where('id', $menuId)
            ->where('restaurant_id', $restaurant->id)
            ->firstOrFail();

        return view('manager.menus.edit', compact('restaurant', 'menu'));
    }

    // Update a menu
    public function update(Request $request, $restaurantId, $menuId)
    {
        $restaurant = Restaurant::where('id', $restaurantId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $menu = Menu::where('id', $menuId)
            ->where('restaurant_id', $restaurant->id)
            ->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $menu->update($validated);

        return redirect()->route('manager.menus.index', $restaurant->id)
            ->with('success', 'Menu updated successfully.');
    }

    // Delete a menu
    public function destroy($restaurantId, $menuId)
    {
        $restaurant = Restaurant::where('id', $restaurantId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $menu = Menu::where('id', $menuId)
            ->where('restaurant_id', $restaurant->id)
            ->firstOrFail();

        $menu->items()->delete();
        $menu->delete();

        return redirect()->route('manager.menus.index', $restaurant->id)
            ->with('success', 'Menu deleted successfully.');
    }

    // Show menu items
    public function showItems($restaurantId, $menuId)
    {
        $restaurant = Restaurant::where('id', $restaurantId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $menu = Menu::where('id', $menuId)
            ->where('restaurant_id', $restaurant->id)
            ->with('items.foodType')
            ->firstOrFail();

        $foodTypes = FoodType::all();

        return view('manager.menus.items', compact('restaurant', 'menu', 'foodTypes'));
    }

    // Create a new menu item
    public function storeItem(Request $request, $restaurantId, $menuId)
    {
        $restaurant = Restaurant::where('id', $restaurantId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $menu = Menu::where('id', $menuId)
            ->where('restaurant_id', $restaurant->id)
            ->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'is_available' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('menu-items', 'public');
        }

        $validated['menu_id'] = $menu->id;
        $validated['is_available'] = $request->has('is_available');

        MenuItem::create($validated);

        return redirect()->route('manager.menus.items', ['restaurantId' => $restaurant->id, 'menuId' => $menu->id])
            ->with('success', 'Menu item added successfully.');
    }

    // Edit a menu item
    public function editItem($restaurantId, $menuId, $itemId)
    {
        $restaurant = Restaurant::where('id', $restaurantId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $menu = Menu::where('id', $menuId)
            ->where('restaurant_id', $restaurant->id)
            ->firstOrFail();

        $item = MenuItem::where('id', $itemId)
            ->where('menu_id', $menu->id)
            ->firstOrFail();

        $foodTypes = FoodType::all();

        return view('manager.menus.edit-item', compact('restaurant', 'menu', 'item', 'foodTypes'));
    }

    // Update a menu item
    public function updateItem(Request $request, $restaurantId, $menuId, $itemId)
    {
        $restaurant = Restaurant::where('id', $restaurantId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $menu = Menu::where('id', $menuId)
            ->where('restaurant_id', $restaurant->id)
            ->firstOrFail();

        $item = MenuItem::where('id', $itemId)
            ->where('menu_id', $menu->id)
            ->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'is_available' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($item->image && Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }

            $validated['image'] = $request->file('image')->store('menu-items', 'public');
        }

        $validated['is_available'] = $request->has('is_available');

        $item->update($validated);

        return redirect()->route('manager.menus.items', ['restaurantId' => $restaurant->id, 'menuId' => $menu->id])
            ->with('success', 'Menu item updated successfully.');
    }


    public function destroyItem($restaurantId, $menuId, $itemId)
    {
        $restaurant = Restaurant::where('id', $restaurantId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $menu = Menu::where('id', $menuId)
            ->where('restaurant_id', $restaurant->id)
            ->firstOrFail();

        $item = MenuItem::where('id', $itemId)
            ->where('menu_id', $menu->id)
            ->firstOrFail();

        if ($item->image && Storage::disk('public')->exists($item->image)) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();

        return redirect()->route('manager.menus.items', ['restaurantId' => $restaurant->id, 'menuId' => $menu->id])
            ->with('success', 'Menu item deleted successfully.');
    }


    public function toggleItemAvailability($restaurantId, $menuId, $itemId)
    {
        $restaurant = Restaurant::where('id', $restaurantId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $menu = Menu::where('id', $menuId)
            ->where('restaurant_id', $restaurant->id)
            ->firstOrFail();

        $item = MenuItem::where('id', $itemId)
            ->where('menu_id', $menu->id)
            ->firstOrFail();

        $item->is_available = !$item->is_available;
        $item->save();

        $status = $item->is_available ? 'available' : 'unavailable';

        return redirect()->route('manager.menus.items', ['restaurantId' => $restaurant->id, 'menuId' => $menu->id])
            ->with('success', "Menu item marked as {$status}.");
    }
}
