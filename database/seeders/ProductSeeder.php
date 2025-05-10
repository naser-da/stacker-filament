<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Industrial Steel Pipe',
                'description' => 'High-quality steel pipe for industrial use',
                'price' => 299.99,
                'sku' => 'ISP-001',
                'category_id' => 1,
            ],
            [
                'name' => 'Plastic Granules',
                'description' => 'Raw plastic material for manufacturing',
                'price' => 89.99,
                'sku' => 'PG-001',
                'category_id' => 1,
            ],
            [
                'name' => 'Cardboard Boxes',
                'description' => 'Standard shipping boxes',
                'price' => 24.99,
                'sku' => 'CB-001',
                'category_id' => 3,
            ],
            [
                'name' => 'Safety Gloves',
                'description' => 'Industrial safety gloves',
                'price' => 19.99,
                'sku' => 'SG-001',
                'category_id' => 4,
            ],
            [
                'name' => 'Motor Bearings',
                'description' => 'Replacement bearings for industrial motors',
                'price' => 49.99,
                'sku' => 'MB-001',
                'category_id' => 5,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
} 