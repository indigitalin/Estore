<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Industry::insert([
            [
                'name' => 'Food Delivery',
                'handle' => 'food_delivery',
                'description' => 'Stores that offer meal delivery services to customers.',
            ],
            [
                'name' => 'Fashion and Clothing',
                'handle' => 'fashion_clothing',
                'description' => 'Stores that sell apparel, accessories, and fashion products.',
            ],
            [
                'name' => 'Electronics and Gadgets',
                'handle' => 'electronics_gadgets',
                'description' => 'Stores specializing in electronic devices and accessories.',
            ],
            [
                'name' => 'Home and Furniture',
                'handle' => 'home_furniture',
                'description' => 'Stores offering furniture, home decor, and appliances.',
            ],
            [
                'name' => 'Beauty and Personal Care',
                'handle' => 'beauty_personal_care',
                'description' => 'Stores focused on beauty products and personal care items.',
            ],
            [
                'name' => 'Books and Stationery',
                'handle' => 'books_stationery',
                'description' => 'Stores that provide books, stationery, and educational materials.',
            ],
            [
                'name' => 'Sports and Outdoor',
                'handle' => 'sports_outdoor',
                'description' => 'Stores selling sports equipment, outdoor gear, and accessories.',
            ],
            [
                'name' => 'Groceries',
                'handle' => 'groceries',
                'description' => 'Stores that offer food, beverages, and daily household items.',
            ],
            [
                'name' => 'Toys and Games',
                'handle' => 'toys_games',
                'description' => 'Stores offering toys, board games, and entertainment for children.',
            ],
            [
                'name' => 'Automotive Parts',
                'handle' => 'automotive_parts',
                'description' => 'Stores providing automotive parts, accessories, and repair tools.',
            ],
        ]);
    }
}
