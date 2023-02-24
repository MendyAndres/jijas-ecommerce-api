<?php

namespace Tests\Unit\Models;

use App\Models\ProductImage;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductImageTest extends TestCase
{

    use RefreshDatabase;

    public function testBelongsToProduct(): void
    {
        $productImage = ProductImage::Factory()->create();

        $this->assertInstanceOf(Product::class, $productImage->product);
    }
}
