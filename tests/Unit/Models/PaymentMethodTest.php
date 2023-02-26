<?php

namespace Tests\Unit\Models;

use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
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

    public function testHasManyPayments(): void
    {
        $paymentMethod = new PaymentMethod();

        $this->assertInstanceOf(Collection::class, $paymentMethod->payments);
    }
}
