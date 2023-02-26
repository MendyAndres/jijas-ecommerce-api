<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Order;
use App\Models\Cart;
use App\Models\User;
use App\Models\Shipping;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function testBelongsToCart(): void
    {
        $order = Order::factory()->create();

        $this->assertInstanceOf(Cart::class, $order->cart);
    }

    public function testBelongsToUser(): void
    {
        $order = Order::factory()->create();

        $this->assertInstanceOf(User::class, $order->user);
    }

    public function testHasOneShipping(): void
    {
        $order = Order::factory()->create();
        Shipping::factory()->create([ 'order_id' => $order->id]);

        $this->assertInstanceOf(Shipping::class, $order->shipping);
    }
}
