<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['Apparel', 'Electronics', 'Home & Living', 'Accessories', 'Footwear'];
        $category = fake()->randomElement($categories);
        $prefix = strtoupper(substr($category, 0, 3));

        $price = fake()->randomFloat(2, 10, 500);

        return [
            'name' => fake()->words(3, true),
            'sku' => $prefix . '-' . fake()->unique()->regexify('[A-Z]{3}-[0-9]{3}'),
            'description' => fake()->paragraph(),
            'price' => $price,
            'sale_price' => fake()->boolean(40) ? round($price * 0.8, 2) : null,
            'category' => $category,
            'stock_quantity' => fake()->numberBetween(0, 200),
            'low_stock_threshold' => 15,
            'status' => fake()->randomElement(['Active', 'Inactive', 'Draft']),
            'image_path' => null,
        ];
    }
}
