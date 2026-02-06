<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cashier>
 */
use App\Models\Cashier;

class CashierFactory extends Factory
{
    protected $model = Cashier::class;

    public function definition(): array
    {
        return [
            'name'   => $this->faker->name(),
            'role'   => $this->faker->randomElement(['cashier', 'manager']),
            'status' => $this->faker->randomElement(['active', 'inactive']),
        ];
    }
}
