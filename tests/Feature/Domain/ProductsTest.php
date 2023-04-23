<?php

namespace Tests\Feature\Domain;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Product;
use App\Models\Subcategory;
use Tests\TestCase;

class ProductsTest extends TestCase
{

    use RefreshDatabase;

    public function testGetAllProducts(): void
    {
        Product::factory()->count(10)->create();
        $response = $this->get('/api/products');

        $response->assertStatus(200);
    }

    public function testGetProductById(): void
    {
        $product = Product::factory()->create();
        $response = $this->get("/api/products/$product->id");

        $response->assertStatus(200);
    }

    public function testStoreProduct(): void
    {
        $subcategory = Subcategory::factory()->create();

        $response = $this->post('/api/products', [
            'subcategory_id' => $subcategory->id,
            'title' => 'Test Product',
            'description' => 'Test Product Description',
            'price' => 100,
        ]);

        $response->assertStatus(201);
    }

    public function testEditProduct(): void
    {
        $product = Product::factory()->create();

        $response = $this->put("/api/products/$product->id", [
            'title' => 'Cambio de nombre',
        ]);

        $response->assertStatus(200);
    }
    public function testDeleteProduct(): void
    {
        $product = Product::factory()->create();

        $response = $this->delete("/api/products/$product->id");

        $response->assertStatus(200);
    }
}
