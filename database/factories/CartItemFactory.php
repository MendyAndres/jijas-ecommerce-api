<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CartItem>
 */
class CartItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cart_id'     => Cart::factory(),
            'product_id'  => Product::factory(),
            'product_qty' => fake()->randomNumber(1, 10),
            'amount'      => fake()->randomFloat(2, 1000, 3000)
        ];
    }
}
