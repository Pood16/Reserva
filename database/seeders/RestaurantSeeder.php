<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    public function run(): void
    {
        // Get all manager users
        $managers = User::where('role', 'manager')->get();

        // Create restaurants for each manager
        foreach ($managers as $manager) {
            Restaurant::factory()->count(2)->create([
                'user_id' => $manager->id
            ]);
        }

        // Create one more restaurant to have 5 total
        Restaurant::factory()->create([
            'user_id' => $managers->first()->id
        ]);
    }
}
