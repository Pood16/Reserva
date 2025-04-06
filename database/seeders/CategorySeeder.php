<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Italian' => 'Classic Italian cuisine including pasta, pizza, and authentic dishes from various regions of Italy.',
            'French' => 'Elegant French cuisine featuring classic techniques, rich flavors, and fine dining experiences.',
            'Japanese' => 'Traditional Japanese dishes including sushi, ramen, tempura and other specialties.',
            'Chinese' => 'Diverse Chinese cuisine spanning regional specialties from Sichuan to Cantonese dishes.',
            'Mexican' => 'Vibrant Mexican food featuring tacos, enchiladas, mole and other traditional dishes.',
            'Indian' => 'Flavorful Indian cuisine with aromatic spices, curries, tandoori specialties and regional dishes.',
            'Thai' => 'Bold Thai flavors combining sweet, sour, salty and spicy elements in authentic dishes.',
            'Mediterranean' => 'Fresh Mediterranean cuisine focused on olive oil, fresh vegetables, and seafood.',
            'American' => 'Classic American comfort food including burgers, steaks, and hearty portions.',
            'Spanish' => 'Spanish cuisine featuring tapas, paella, and dishes rich in olive oil and fresh ingredients.',
            'Greek' => 'Traditional Greek food with olive oil, feta cheese, fresh vegetables and grilled meats.',
            'Vegetarian' => 'Creative vegetarian dishes that focus on fresh produce and plant-based proteins.',
            'Vegan' => 'Entirely plant-based cuisine without any animal products.',
            'Seafood' => 'Fresh seafood dishes highlighting fish, shellfish and oceanic delicacies.',
            'Steakhouse' => 'Premium cuts of meat perfectly aged and grilled to perfection.',
            'Fusion' => 'Innovative cuisine blending culinary traditions from multiple cultures.',
            'Fast Food' => 'Quick service restaurants offering convenient meals prepared rapidly.',
            'Fine Dining' => 'Upscale establishments offering premium ingredients with exceptional service.',
            'Bistro' => 'Casual yet refined dining with a focus on simple, well-prepared dishes.',
            'Café' => 'Relaxed establishments serving light meals, pastries and coffee.',
        ];

        foreach ($categories as $name => $description) {
            Category::create([
                'name' => $name,
                'description' => $description,
            ]);
        }
    }
}
