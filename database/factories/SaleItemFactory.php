<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale_Item>
 */
class SaleItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $saleId = \App\Models\Sale::inRandomOrder()->first()->id;
        $variantId = \App\Models\Variant::inRandomOrder()->first()->id;

        // Keep trying until we get a unique pair
        while (\App\Models\SaleItem::where('sale_id', $saleId)->where('variant_id', $variantId)->exists()) {
            $saleId = \App\Models\Sale::inRandomOrder()->first()->id;
            $variantId = \App\Models\Variant::inRandomOrder()->first()->id;
        }

        $quantity = $this->faker->numberBetween(1, 5);
        $unitPrice = $this->faker->randomFloat(2, 1, 1000);

        return [
            'sale_id' => \App\Models\Sale::inRandomOrder()->value('id'),
            'variant_id' => \App\Models\Variant::inRandomOrder()->value('id'),
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'subtotal' => $quantity * $unitPrice,
        ];
    }
}
