<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Income categories
            ['name' => 'Gaji', 'type' => 'income'],
            ['name' => 'Freelance', 'type' => 'income'],
            ['name' => 'Bonus', 'type' => 'income'],
            ['name' => 'Investasi', 'type' => 'income'],

            // Expense categories
            ['name' => 'Makan & Minum', 'type' => 'expense'],
            ['name' => 'Transportasi', 'type' => 'expense'],
            ['name' => 'Belanja', 'type' => 'expense'],
            ['name' => 'Tagihan', 'type' => 'expense'],
            ['name' => 'Hiburan', 'type' => 'expense'],
            ['name' => 'Kesehatan', 'type' => 'expense'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
