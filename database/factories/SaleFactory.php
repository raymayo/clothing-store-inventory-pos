<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sale_date' => now(),
            'total_amount' => $this->faker->randomFloat(2, 1, 1000),
            'cashier_id' => \App\Models\Cashier::inRandomOrder()->value('id'),
            'status' => $this->faker->randomElement(['completed', 'refunded']),
        ];
    }
}
