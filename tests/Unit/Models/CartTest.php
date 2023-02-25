<?php

namespace Tests\Unit\Models;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function testBelongsToUser(): void
    {
        $cart = Cart::factory()->create();

        $this->assertInstanceOf(User::class, $cart->user);
    }

    public function testHasManyCartItems(): void
    {
        $cart = new Cart();

        $this->assertInstanceOf(Collection::class, $cart->cartItems);
    }
}