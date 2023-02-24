<?php

namespace Tests\Unit\Models;

use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{

    use RefreshDatabase;
    
    public function testHasManyProductImages(): void
    {
        $product = new Product();

        $this->assertInstanceOf(Collection::class, $product->productImages);
    }

    public function testBelongsToSubcategory(): void
    {
        $product = Product::factory()->create();

        $this->assertInstanceOf(Subcategory::class, $product->subcategory);
    }
}
