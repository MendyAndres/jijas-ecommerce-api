<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Address;
use App\Models\Order;
use App\Models\Shipping;
use Tests\TestCase;

class ShippingTest extends TestCase
{
    use RefreshDatabase;

    public function testBelongsToOrder(): void
    {
        $shipping = Shipping::factory()->create();

        $this->assertInstanceOf(Order::class, $shipping->order);
    }

    public function testBelongsToAddress(): void
    {
        $shipping = Shipping::factory()->create();

        $this->assertInstanceOf(Address::class, $shipping->address);
    }
}
