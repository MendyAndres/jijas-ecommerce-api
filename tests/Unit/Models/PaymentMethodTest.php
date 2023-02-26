<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\PaymentMethod;
use App\Models\User;
use Tests\TestCase;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    public function testBelongsToUser(): void
    {
        $paymentMethod = PaymentMethod::factory()->create();

        $this->assertInstanceOf(User::class, $paymentMethod->user);
    }
}
