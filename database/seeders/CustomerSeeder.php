<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Create 20 customers with realistic data
        for ($i = 0; $i < 20; $i++) {
            Customer::create([
                'name' => $faker->company,
                'email' => $faker->companyEmail,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
                'notes' => $faker->optional(0.7)->sentence,
            ]);
        }
    }
} 