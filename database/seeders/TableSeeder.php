<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use App\Models\Table;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    public function run(): void
    {
        // Get all restaurants
        $restaurants = Restaurant::all();

        // Create tables for each restaurant
        foreach ($restaurants as $restaurant) {
            // Create indoor tables
            Table::factory()->count(2)->indoors()->create([
                'restaurant_id' => $restaurant->id
            ]);

            // Create outdoor tables
            Table::factory()->count(2)->outdoors()->create([
                'restaurant_id' => $restaurant->id
            ]);

            // Create a terrace table
            Table::factory()->create([
                'restaurant_id' => $restaurant->id,
                'location' => 'terrace'
            ]);
        }
    }
}
