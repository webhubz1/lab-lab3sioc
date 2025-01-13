<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        Product::create([
            'product_name' => 'Air Max 2024',
            'price' => 150,
            'description' => 'Latest running shoes',
            'discount' => 10,
            'size' => '10',
            'stock' => 20,
            'image' => 'airmax2024.jpg',
        ]);
    }
}