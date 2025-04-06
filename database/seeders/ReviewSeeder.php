<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing records
        DB::table('reviews')->truncate();

        // Get all users and restaurants
        $users = User::all();
        $restaurants = Restaurant::all();

        // Exit if no users or restaurants exist
        if ($users->isEmpty() || $restaurants->isEmpty()) {
            $this->command->info('Please seed users and restaurants first.');
            return;
        }

        // Create random reviews
        $faker = \Faker\Factory::create();

        // Decide how many reviews to create
        $reviewCount = 50; // Adjust this number as needed

        for ($i = 0; $i < $reviewCount; $i++) {
            Review::create([
                'user_id' => $users->random()->id,
                'restaurant_id' => $restaurants->random()->id,
                'rating' => $faker->numberBetween(1, 5),
                'comment' => $faker->paragraph(),
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => now(),
            ]);
        }

        $this->command->info($reviewCount . ' reviews created successfully.');
    }
}
