<?php


namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Table;
use App\Models\OpeningDay;
use App\Models\RestaurantImage;
use App\Models\FoodType;
use App\Models\RestaurantFoodType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManagerRestaurantController extends Controller {



    // List of my restaurants
    public function restaurantsList(){
        $myRestaurants = Restaurant::where('user_id', Auth::id())
            ->with('reviews')
            ->with('tables')
            ->with('foodTypes')
            ->with('menus')
            ->get();

        $foodTypes = FoodType::all();
        return view('manager.restaurants.restaurants', compact('myRestaurants', 'foodTypes'));
    }

    // Show my restaurants details
    public function restaurantDetails($id)
    {
        $restaurant = Restaurant::where('id', $id)
            ->where('user_id', Auth::id())
            ->with(['reviews', 'images', 'openingDays', 'tables', 'foodTypes'])
            ->firstOrFail();

        return view('manager.restaurants.restaurant-details', compact('restaurant'));
    }

    // Add Images to my restaurants
    public function addRestaurantImage(Request $request, $id)
    {
        $restaurant = Restaurant::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'image' => 'required|image|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('restaurant-images', 'public');

            RestaurantImage::create([
                'restaurant_id' => $restaurant->id,
                'image_path' => $imagePath,
            ]);

            return redirect()->back()->with('success', 'Image added successfully.');
        }
        return redirect()->back()->with('error', 'Failed to upload image.');
    }

    // Delete a specific image
    public function deleteRestaurantImage($id, $imageId)
    {
        $restaurant = Restaurant::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $image = RestaurantImage::where('id', $imageId)
            ->where('restaurant_id', $restaurant->id)
            ->firstOrFail();
        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }
        $image->delete();
        return redirect()->back()->with('success', 'Image deleted successfully.');
    }

    // Create a restaurant
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
            'food_types' => 'nullable|array',
            'food_types.*' => 'exists:food_types,id',
        ]);
        $openingDays = $validated['opening_days'];
        unset($validated['opening_days']);

        $foodTypes = $request->input('food_types', []);
        unset($validated['food_types']);

        $validated['user_id'] = Auth::id();
        if ($request->hasFile('cover_image')) {
            $validated['cover_image']= $request->file('cover_image')->store('restaurants', 'public');
        } else {
            $validated['cover_image'] = 'default_restaurant.jpg';
        }

        $restaurant = Restaurant::create($validated);

        // Add opening days
        foreach ($openingDays as $day) {
            OpeningDay::create([
                'restaurant_id' => $restaurant->id,
                'day_of_week' => $day
            ]);
        }

        // Add food types
        if (!empty($foodTypes)) {
            foreach ($foodTypes as $foodTypeId) {
                RestaurantFoodType::create([
                    'restaurant_id' => $restaurant->id,
                    'food_type_id' => $foodTypeId
                ]);
            }
        }

        return redirect()->back()->with('success', 'Restaurant created successfully.');
    }

    // Show update restaurant page
    public function showEditRestaurant(Request $request, $id){
        $restaurant = Restaurant::where('user_id', Auth::id())
                        ->where('id', $id)
                        ->with(['images', 'openingDays', 'foodTypes'])
                        ->firstOrFail();
        $foodTypes = FoodType::all();
        return view('manager.restaurants.edit', compact('restaurant', 'foodTypes'));
    }

    // Toggle my restaurants status
    public function toggleStatus($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        if ($restaurant->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }
        $restaurant->is_active = !$restaurant->is_active;
        $restaurant->save();
        $status = $restaurant->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Restaurant {$status} successfully.");
    }



    // Update restaurant
    public function updateRestaurant(Request $request, $id)
    {
        // dd($request->all());

        $restaurant = Restaurant::where('id', $id)
            ->where('user_id', Auth::id())
            ->with(['images', 'openingDays', 'foodTypes'])
            ->firstOrFail();
            $section = $request->input('section', 'general');
            switch ($section) {
                case 'general':
                    return $this->updateGeneralInfo($request, $restaurant);

                case 'contact':
                    return $this->updateContactInfo($request, $restaurant);

                case 'hours':
                    return $this->updateBusinessHours($request, $restaurant);

                case 'images':
                    return $this->updateImages($request, $restaurant);

                case 'status':
                    return $this->updateStatus($request, $restaurant);

                case 'food_types':
                    return $this->updateFoodTypes($request, $restaurant);

                default:
                    return redirect()->back()->with('error', 'Invalid section specified.');
            }
    }

    // Update general information (section: general)
    private function updateGeneralInfo(Request $request, Restaurant $restaurant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
        ]);
        $restaurant->update($validated);
        return redirect()->back()->with('success', 'General information updated successfully.');
    }

    // Update contact information (section: contact)
    private function updateContactInfo(Request $request, Restaurant $restaurant)
    {

        $validated = $request->validate([
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'website' => 'nullable|url|max:255',
        ]);


        $restaurant->update($validated);


        return redirect()->back()->with('success', 'Contact information updated successfully.');
    }

    // Update business hours (section: hours)
    private function updateBusinessHours(Request $request, Restaurant $restaurant)
    {

        $validated = $request->validate([
            'opening_time' => 'required',
            'closing_time' => 'required',
            'opening_days' => 'required|array',
            'opening_days.*' => 'string'
        ]);

        $restaurant->update([
            'opening_time' => $validated['opening_time'],
            'closing_time' => $validated['closing_time'],
        ]);

        $restaurant->openingDays()->delete();

        foreach ($validated['opening_days'] as $day) {
            OpeningDay::create([
                'restaurant_id' => $restaurant->id,
                'day_of_week' => $day
            ]);
        }

        return redirect()->back()->with('success', 'Business hours updated successfully.');
    }

    private function updateImages(Request $request, Restaurant $restaurant)
    {
        $validated = $request->validate([
            'cover_image' => 'nullable|image|max:2048',
            'additional_images' => 'nullable|array',
            'additional_images.*' => 'image|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($restaurant->cover_image !== 'default_restaurant.jpg' && Storage::disk('public')->exists($restaurant->cover_image)) {
                Storage::disk('public')->delete($restaurant->cover_image);
            }

            $coverImagePath = $request->file('cover_image')->store('restaurants', 'public');
            $restaurant->update(['cover_image' => $coverImagePath]);
        }

        if ($request->hasFile('additional_images')) {
            foreach ($request->file('additional_images') as $image) {
                $imagePath = $image->store('restaurant-images', 'public');
                RestaurantImage::create([
                    'restaurant_id' => $restaurant->id,
                    'image_path' => $imagePath,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Restaurant images updated successfully.');
    }

    private function updateStatus(Request $request, Restaurant $restaurant)
    {
        $validated = $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $restaurant->update([
            'is_active' => $validated['is_active']
        ]);

        $statusText = $validated['is_active'] ? 'activated' : 'deactivated';

        return redirect()->back()->with('success', "Restaurant {$statusText} successfully.");
    }

    // Update food types (section: food_types)
    private function updateFoodTypes(Request $request, Restaurant $restaurant)
    {
        $validated = $request->validate([
            'food_types' => 'nullable|array',
            'food_types.*' => 'exists:food_types,id',
        ]);

        // Delete existing restaurant food types
        RestaurantFoodType::where('restaurant_id', $restaurant->id)->delete();

        // Add new food types
        if (isset($validated['food_types']) && !empty($validated['food_types'])) {
            foreach ($validated['food_types'] as $foodTypeId) {
                RestaurantFoodType::create([
                    'restaurant_id' => $restaurant->id,
                    'food_type_id' => $foodTypeId
                ]);
            }
        }

        return redirect()->back()->with('success', 'Food types updated successfully.');
    }
}
