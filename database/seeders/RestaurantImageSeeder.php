<?php

namespace Database\Seeders;

use App\Models\RestaurantImage;
use App\Models\Restaurant;
use Illuminate\Database\Seeder;

class RestaurantImageSeeder extends Seeder
{
    public function run(): void
    {
        // Get all restaurants
        $restaurants = Restaurant::all();

        foreach ($restaurants as $restaurant) {
            // For each restaurant, create 5 images
            $images = [
                [
                    'restaurant_id' => $restaurant->id,
                    'image_path' => 'restaurants/' . $restaurant->id . '/interior1.jpg',
                ],
                [
                    'restaurant_id' => $restaurant->id,
                    'image_path' => 'restaurants/' . $restaurant->id . '/interior2.jpg',
                ],
                [
                    'restaurant_id' => $restaurant->id,
                    'image_path' => 'restaurants/' . $restaurant->id . '/food1.jpg',
                ],
                [
                    'restaurant_id' => $restaurant->id,
                    'image_path' => 'restaurants/' . $restaurant->id . '/food2.jpg',
                ],
                [
                    'restaurant_id' => $restaurant->id,
                    'image_path' => 'restaurants/' . $restaurant->id . '/exterior.jpg',
                ],
            ];

            foreach ($images as $imageData) {
                RestaurantImage::create($imageData);
            }
        }
    }
}
