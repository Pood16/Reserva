<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\Table;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        // Get some users, restaurants and tables to work with
        $users = User::whereIn('id', [4, 5])->get();
        $restaurants = Restaurant::take(5)->get();

        $statuses = ['pending', 'confirmed', 'cancelled', 'completed'];

        // Create 5 reservations
        $reservations = [
            [
                'booking_date' => Carbon::now()->addDays(1)->setHour(18)->setMinute(0),
                'end_time' => Carbon::now()->addDays(1)->setHour(20)->setMinute(0),
                'guests_number' => 2,
                'special_requests' => 'Window seat preferred',
                'status' => 'confirmed',
            ],
            [
                'booking_date' => Carbon::now()->addDays(2)->setHour(19)->setMinute(30),
                'end_time' => Carbon::now()->addDays(2)->setHour(21)->setMinute(30),
                'guests_number' => 4,
                'special_requests' => 'Birthday celebration',
                'status' => 'pending',
            ],
            [
                'booking_date' => Carbon::now()->subDays(2)->setHour(12)->setMinute(0),
                'end_time' => Carbon::now()->subDays(2)->setHour(14)->setMinute(0),
                'guests_number' => 6,
                'special_requests' => 'Gluten-free options needed',
                'status' => 'completed',
            ],
            [
                'booking_date' => Carbon::now()->addDays(5)->setHour(20)->setMinute(0),
                'end_time' => Carbon::now()->addDays(5)->setHour(22)->setMinute(0),
                'guests_number' => 2,
                'special_requests' => '',
                'status' => 'confirmed',
            ],
            [
                'booking_date' => Carbon::now()->addDays(3)->setHour(18)->setMinute(30),
                'end_time' => Carbon::now()->addDays(3)->setHour(20)->setMinute(30),
                'guests_number' => 3,
                'special_requests' => 'Allergy to nuts',
                'status' => 'cancelled',
            ],
        ];

        foreach ($reservations as $key => $reservationData) {
            // Get a restaurant and a table for this reservation
            $restaurant = $restaurants[$key % count($restaurants)];

            // Find a suitable table for this restaurant
            $table = Table::where('restaurant_id', $restaurant->id)
                          ->where('capacity', '>=', $reservationData['guests_number'])
                          ->where('is_active', true)
                          ->first();

            if (!$table) {
                // If no suitable table is found, pick the first one
                $table = Table::where('restaurant_id', $restaurant->id)->first();
            }

            $user = $users[$key % count($users)];

            // Add the relationships to the reservation data
            $reservationData['restaurant_id'] = $restaurant->id;
            $reservationData['table_id'] = $table->id;
            $reservationData['user_id'] = $user->id;

            Reservation::create($reservationData);
        }
    }
}
