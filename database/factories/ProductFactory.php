<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
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
        $categories = ['Electrónicos', 'Ropa', 'Alimentos', 'Hogar', 'Deportes', 'Juguetes'];

        return [
            'code' => fake()->unique()->numerify('PROD-####'),
            'name' => fake()->words(2, true),
            'category' => fake()->randomElement($categories),
            'branch' => fake()->randomElement(Product::$branchOptions),
            'description' => fake()->sentence(8),
            'quantity' => fake()->numberBetween(0, 100),
            'sale_price' => fake()->randomFloat(2, 10, 1000),
        ];
    }
}
