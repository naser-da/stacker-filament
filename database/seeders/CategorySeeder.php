<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Raw Materials', 'description' => 'Basic materials used in production'],
            ['name' => 'Finished Products', 'description' => 'Completed items ready for sale'],
            ['name' => 'Packaging Materials', 'description' => 'Materials used for product packaging'],
            ['name' => 'Tools & Equipment', 'description' => 'Tools and equipment used in production'],
            ['name' => 'Spare Parts', 'description' => 'Replacement parts for machinery'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
} 