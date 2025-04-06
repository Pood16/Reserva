<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RestaurantFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'description' => $this->faker->paragraph(),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->companyEmail(),
            'website' => $this->faker->url(),
            'opening_time' => $this->faker->time('H:i:s', '12:00:00'),
            'closing_time' => $this->faker->time('H:i:s', '23:00:00'),
            'opening_days' => json_encode(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']),
            'user_id' => User::factory()->manager(),
            'cover_image' => 'default_restaurant.jpg',
            'is_active' => true,
            'max_booking_days_ahead' => $this->faker->numberBetween(7, 60),
        ];
    }
}
