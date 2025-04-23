<?php


namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Table;
use App\Models\OpeningDay;
use App\Models\RestaurantImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManagerController extends Controller {

    // Manager Dashboard
    public function dashboard()
    {
        $user = Auth::user();
        $restaurants = Restaurant::where('user_id', $user->id)->get();
        $restaurantCount = $restaurants->count();
        $tableCount = Table::whereIn('restaurant_id', $restaurants->pluck('id'))->count();
        $activeRestaurants = $restaurants->where('is_active', true)->count();

        return view('manager.dashboard', compact(
            'user',
            'restaurants',
            'restaurantCount',
            'tableCount',
            'activeRestaurants'
        ));
    }

    // =============================>>   Restaurants functions
    // List of my restaurants
    public function restaurantsList(){
        $myRestaurants = Restaurant::where('user_id', Auth::id())
            ->with('reviews')
            ->with('tables')
            ->get();
        return view('manager.restaurants.restaurants', compact('myRestaurants'));
    }
    // Show my restaurants details
    public function restaurantDetails($id)
    {
        $restaurant = Restaurant::where('id', $id)
            ->where('user_id', Auth::id())
            ->with(['reviews', 'images', 'openingDays', 'tables'])
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
        ]);
        $openingDays = $validated['opening_days'];
        unset($validated['opening_days']);

        $validated['user_id'] = Auth::id();
        if ($request->hasFile('cover_image')) {
            $validated['cover_image']= $request->file('cover_image')->store('restaurants', 'public');
        } else {
            $validated['cover_image'] = 'default_restaurant.jpg';
        }

        $restaurant = Restaurant::create($validated);
        foreach ($openingDays as $day) {
            OpeningDay::create([
                'restaurant_id' => $restaurant->id,
                'day_of_week' => $day
            ]);
        }
        return redirect()->back()->with('success', 'Restaurant created successfully.');
    }

    // Show update restaurant page
    public function showEditRestaurant(Request $request, $id){
        $restaurant = Restaurant::where('user_id', Auth::id())
                        ->where('id', $id)
                        ->with(['images', 'openingDays'])
                        ->firstOrFail();
            return view('manager.restaurants.edit', compact('restaurant'));
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
            ->with(['images', 'openingDays'])
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


}
