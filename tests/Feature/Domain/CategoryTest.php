<?php

namespace Tests\Feature\Domain;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{

    use RefreshDatabase;

    public function testGetAllCategorys(): void
    {
        Category::factory()->count(10)->create();
        $response = $this->get('/api/categories');

        $response->assertStatus(200);
    }

    public function testGetCategoryById(): void
    {
        $category = Category::factory()->create();
        $response = $this->get("/api/categories/$category->id");

        $response->assertStatus(200);
    }

    public function testStoreCategory(): void
    {

        $response = $this->post('/api/categories', [
            'cod' => 'Test Category',
            'name' => 'Test name',
            'description' => 'Test Category Description',
        ]);

        $response->assertStatus(201);
    }

    public function testEditCategory(): void
    {
        $category = Category::factory()->create();

        $response = $this->put("/api/categories/$category->id", [
            'name' => 'Cambio de nombre',
        ]);

        $response->assertStatus(200);
    }
    public function testDeleteCategory(): void
    {
        $category = Category::factory()->create();

        $response = $this->delete("/api/categories/$category->id");

        $response->assertStatus(200);
    }
}
