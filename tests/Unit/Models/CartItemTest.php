<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Tests\TestCase;

class CartItemTest extends TestCase
{
    use RefreshDatabase;

    public function testBelongsToProduct(): void
    {
        $cartItem = CartItem::factory()->create();

        $this->assertInstanceOf(Product::class, $cartItem->product);
    }

    public function testBelongsToCart(): void
    {
        $cartItem = CartItem::factory()->create();

        $this->assertInstanceOf(Cart::class, $cartItem->cart);
    }
}
