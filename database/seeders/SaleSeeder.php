<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SaleSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $products = Product::all();
        $customers = Customer::all();

        // Create 50 sales with realistic data
        for ($i = 0; $i < 50; $i++) {
            $customerId = $faker->boolean(80) ? $faker->randomElement($customers)->id : null;

            $sale = Sale::create([
                'customer_id' => $customerId,
                'total_amount' => 0, // Will be calculated after adding products
                'notes' => $faker->optional(0.3)->sentence,
            ]);

            // Add 1-5 random products to each sale
            $saleProducts = $faker->randomElements($products, $faker->numberBetween(1, 5));
            $totalAmount = 0;

            foreach ($saleProducts as $product) {
                $quantity = $faker->numberBetween(1, 10);
                $unitPrice = $product->price;
                $totalAmount += $quantity * $unitPrice;

                $sale->products()->attach($product->id, [
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                ]);
            }

            // Update the total amount
            $sale->update(['total_amount' => $totalAmount]);
        }
    }
} 