<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentMethod>
 */
class PaymentMethodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'card_type' => fake()->creditCardType,
            'card_number' => fake()->creditCardNumber,
            'card_expiration_date' => fake()->creditCardExpirationDate,
            'card_fullname' => fake()->name,
        ];
    }
}
