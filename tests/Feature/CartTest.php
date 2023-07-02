<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function testAddToCart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/cart/add', [
            'product_id' => $product->id,
            'product_qty' => 1,
        ]);

        $response->assertStatus(201)
            ->assertJson(['message' => 'Product added to cart successfully.']);
    }

    public function testRemoveFromCart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $cart = Cart::factory()->create(['user_id' => $user->id]);
        CartItem::factory()->create(['cart_id' => $cart->id, 'product_id' => $product->id]);

        $response = $this->actingAs($user)->deleteJson('/api/cart/remove', [
            'product_id' => $product->id,
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Product removed from cart successfully.']);
    }

    public function testUpdateCartItemQuantity()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $cart = Cart::factory()->create(['user_id' => $user->id]);
        CartItem::factory()->create(['cart_id' => $cart->id, 'product_id' => $product->id, 'product_qty' => 1]);

        $response = $this->actingAs($user)->putJson('/api/cart/update', [
            'product_id' => $product->id,
            'product_qty' => 2,
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Cart item quantity updated successfully.']);
    }

    public function testGetCartItems()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create(['user_id' => $user->id]);
        CartItem::factory()->count(3)->create(['cart_id' => $cart->id]);

        $response = $this->actingAs($user)->getJson('/api/cart/items');

        $response->assertStatus(200);
        $this->assertCount(3, $response->json('cart_items'));
    }

    public function testClearCart()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create(['user_id' => $user->id]);
        CartItem::factory()->count(3)->create(['cart_id' => $cart->id]);

        $response = $this->actingAs($user)->deleteJson('/api/cart/clear');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Cart cleared successfully.']);
    }

    public function testMergeCarts()
    {
        $user = User::factory()->create();
        $product1 = Product::factory()->create();
        $product2 = Product::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/cart/merge', [
            'items' => [
                ['product_id' => $product1->id, 'product_qty' => 1, 'amount' => $product1->price],
                ['product_id' => $product2->id, 'product_qty' => 2, 'amount' => $product2->price],
            ],
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Carritos fusionados con éxito.']);
    }

    public function testAddNonExistingProductToCart()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/cart/add', [
            'product_id' => 9999,
            'product_qty' => 1,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['product_id']);
    }

    public function testAddNegativeQuantityToCart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/cart/add', [
            'product_id' => $product->id,
            'product_qty' => -1,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['product_qty']);
    }

    public function testUnauthenticatedUserCannotAddToCart()
    {
        $product = Product::factory()->create();

        $response = $this->postJson('/api/cart/add', [
            'product_id' => $product->id,
            'product_qty' => 1,
        ]);

        $response->assertStatus(401);
    }
}
