<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class CategoryTest extends TestCase
{

    public function testHasManySubcategories()
    {
        $category = new Category();

        $this->assertInstanceOf(Collection::class, $category->subcategories);
    }
}
