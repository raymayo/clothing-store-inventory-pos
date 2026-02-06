<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::inRandomOrder()->value('id'), // pick random existing category
            'name'        => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'gender'      => $this->faker->randomElement(['men','women','unisex']),
            'base_price'  => $this->faker->randomFloat(2, 10, 100),
            'status'      => $this->faker->randomElement(['active', 'discontinued']),
        ];
    }
}
