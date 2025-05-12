<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'unit_id' => 1,
            'warranty_id' => 1,
            'name' => fake()->name(),
            'sku' => fake()->unique()->countryCode(),
            'dp_price' => rand(10,90),
            'mrp_price' => rand(10,90),
            'created_by' => 1,
        ];
    }
}
