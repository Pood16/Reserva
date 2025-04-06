<?php

namespace Database\Factories;

use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

class TableFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => 'Table ' . $this->faker->randomNumber(2),
            'capacity' => $this->faker->numberBetween(2, 10),
            'is_available' => $this->faker->boolean(80),
            'description' => $this->faker->optional(0.7)->sentence(),
            'location' => $this->faker->randomElement(['indoors', 'outdoors', 'terrace']),
            'restaurant_id' => Restaurant::factory(),
            'is_active' => $this->faker->boolean(90),
        ];
    }

    public function available()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_available' => true,
            ];
        });
    }

    public function indoors()
    {
        return $this->state(function (array $attributes) {
            return [
                'location' => 'indoors',
            ];
        });
    }

    public function outdoors()
    {
        return $this->state(function (array $attributes) {
            return [
                'location' => 'outdoors',
            ];
        });
    }
}
