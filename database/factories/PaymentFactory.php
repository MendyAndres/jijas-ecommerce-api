<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id'          => Order::factory(),
            'payment_method_id' => PaymentMethod::factory(),
            'payment_status'    => 'APPROVED'
        ];
    }
}
