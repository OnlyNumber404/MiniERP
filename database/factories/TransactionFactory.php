<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    public function definition(): array
    {
        $categoryIds = Category::pluck('id');

        return [
            'trans_date' => fake()->dateTimeBetween('-1 year', 'now'),
            'desc' => fake()->sentence(3),
            'amount' => fake()->randomFloat(2, 1000, 50000),
            'category_id' => $categoryIds->random(),
        ];
    }
}
