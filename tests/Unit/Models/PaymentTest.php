<?php

namespace Tests\Unit\Models;

use App\Models\PaymentMethod;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function testBelongsToOrder(): void
    {
        $payment = Payment::factory()->create();

        $this->assertInstanceOf(Order::class, $payment->order);
    }

    public function testBelongsToPaymentMethod(): void
    {
        $payment = Payment::factory()->create();

        $this->assertInstanceOf(PaymentMethod::class, $payment->paymentMethod);
    }
}
