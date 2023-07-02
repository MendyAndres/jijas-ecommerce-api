<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RequestValidationTest extends TestCase
{
    use RefreshDatabase;

    public function testAddToCartFailsIfDataIsInvalid(): void
    {
        $user = User::factory()->create();
    
        $response = $this->actingAs($user)->postJson('/api/cart/add', [
            'product_id' => '', 
            'product_qty' => '',
        ]);
    
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['product_id', 'product_qty']);
    }

    public function testMergeCartsFailsIfDataIsInvalid()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/cart/merge', [
            'items' => [
                ['product_id' => '', 'product_qty' => '', 'amount' => ''] // faltantes
            ],
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['items.0.product_id', 'items.0.product_qty', 'items.0.amount']);
    }

    public function testMergeCartsWithNegativeQuantity()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/cart/merge', [
            'items' => [
                ['product_id' => $product->id, 'product_qty' => -1, 'amount' => 10.00]
            ],
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['items.0.product_qty']);
    }

    public function testMergeCartsWithNonExistingProduct()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/cart/merge', [
            'items' => [
                ['product_id' => 9999, 'product_qty' => 1, 'amount' => 10.00]
            ],
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['items.0.product_id']);
    }
}
