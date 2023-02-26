<?php

namespace Tests\Unit\Models;

use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    public function testBelongsToUser(): void
    {
        $paymentMethod = PaymentMethod::factory()->create();

        $this->assertInstanceOf(User::class, $paymentMethod->user);
    }

    public function testHasOnePayment(): void
    {
        $paymentMethod = PaymentMethod::factory()->create();
        Payment::factory()->create(['payment_method_id' => $paymentMethod->id]);

        $this->assertInstanceOf(Payment::class, $paymentMethod->payment);
    }
}
