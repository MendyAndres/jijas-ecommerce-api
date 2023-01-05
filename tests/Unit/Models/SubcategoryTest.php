<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubcategoryTest extends TestCase
{
    use RefreshDatabase;
    
    public function testBelongsToCategory()
    {
        $subcategory = Subcategory::factory()->create();

        $this->assertInstanceOf(Category::class, $subcategory->category);
    }
}
