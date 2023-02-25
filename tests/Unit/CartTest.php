<?php

namespace Tests\Unit;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function testBelongsToUser(): void
    {
        $cart = Cart::factory()->create();

        $this->assertInstanceOf(User::class, $cart->user);
    }
}