<?php

namespace App\Services;

use App\Http\Requests\Subcategory\StoreRequest;
use App\Http\Requests\Subcategory\UpdateRequest;
use App\Models\Subcategory;

class SubcategoryService
{
    public function index(): array
    {
        return Subcategory::all()->toArray();
    }

    public function store(StoreRequest $request): array
    {
        $category = Subcategory::create($request->all());
        return $category->toArray();
    }

    public function show(string $categoryId): array
    {
        $category = Subcategory::findOrFail($categoryId);
        return $category->toArray();
    }

    public function update(UpdateRequest $request, string $categoryId): array
    {
        $category = Subcategory::findOrFail($categoryId);
        $category->fill($request->except('id'));

        if($category->isClean()) {
            return ['error' => 'At least one value must change', 'code' => 422];
        }

        $category->save();

        return $category->toArray();
    }

    public function destroy(string $id): array
    {
        $category = Subcategory::findOrFail($id);
        $category->delete();
        return $category->toArray();
    }
}