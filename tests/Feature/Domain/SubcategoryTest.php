<?php

namespace Tests\Feature\Domain;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubcategoryTest extends TestCase
{

    use RefreshDatabase;

    public function testGetAllSubcategories(): void
    {
        Subcategory::factory()->count(10)->create();
        $response = $this->get('/api/subcategories');

        $response->assertStatus(200);
    }

    public function testGetSubcategoryById(): void
    {
        $subcategory = Subcategory::factory()->create();
        $response = $this->get("/api/subcategories/$subcategory->id");

        $response->assertStatus(200);
    }

    public function testStoreSubcategory(): void
    {
        $category = Category::factory()->create();

        $response = $this->post('/api/subcategories', [
            'category_id' => $category->id,
            'cod' => 'Test Subcategory',
            'name' => 'Test name',
            'description' => 'Test Subcategory Description',
        ]);

        $response->assertStatus(201);
    }

    public function testEditSubcategory(): void
    {
        $subcategory = Subcategory::factory()->create();

        $response = $this->put("/api/subcategories/$subcategory->id", [
            'name' => 'Cambio de nombre',
        ]);

        $response->assertStatus(200);
    }
    public function testDeleteSubcategory(): void
    {
        $subcategory = Subcategory::factory()->create();

        $response = $this->delete("/api/subcategories/$subcategory->id");

        $response->assertStatus(200);
    }
}
