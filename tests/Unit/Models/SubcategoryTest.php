<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubcategoryTest extends TestCase
{
    use RefreshDatabase;
    
    public function testBelongsToCategory(): void
    {
        $subcategory = Subcategory::factory()->create();

        $this->assertInstanceOf(Category::class, $subcategory->category);
    }

    public function testHasManyProducts(): void
    {
        $subcategory = new Subcategory();

        $this->assertInstanceOf(Collection::class, $subcategory->products);
    }
}
