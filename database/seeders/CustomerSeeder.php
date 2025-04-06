<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        // Get all client users
        $clients = User::where('role', 'client')->get();

        // Create a customer profile for each client
        foreach ($clients as $client) {
            Customer::factory()->create([
                'user_id' => $client->id,
                'name' => $client->name,
                'email' => $client->email
            ]);
        }

        // Create 3 more customers with new users
        Customer::factory()->count(3)->create();
    }
}
