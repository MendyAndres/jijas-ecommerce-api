<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductService
{
    public function index(): array
    {
        return Product::all()->toArray();
    }

    public function store(Request $request): array
    {
        $product = Product::create($request->all());
        return $product->toArray();
    }

    public function show(string $productId): array
    {
        $product = $this->getProductById($productId);
        return $product->toArray();
    }

    public function getProductById(string $productId): Product | null
    {
        return Product::findOrFail($productId);
    }

    public function update(Request $request, string $productId): array
    {
        $product = Product::findOrFail($productId);
        $product->fill($request->except('id'));

        if($product->isClean()) {
            return ['error' => 'At least one value must change', 'code' => 422];
        }

        $product->save();

        return $product->toArray();
    }

    public function destroy(string $id): array
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return $product->toArray();
    }
}