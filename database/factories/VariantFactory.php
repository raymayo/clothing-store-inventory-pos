<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Variant>
 */
class VariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::inRandomOrder()->value('id'), // pick random existing product
            'size'       => $this->faker->randomElement(['S', 'M', 'L', 'XL']),
            'color'      => $this->faker->safeColorName(),
            'sku'        => $this->faker->unique()->bothify('SKU-####-????'),
            'current_stock' => $this->faker->numberBetween(0, 15),
        ];
    }
}
