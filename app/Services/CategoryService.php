<?php

namespace App\Services;

use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Models\Category;

class CategoryService
{
    public function index(): array
    {
        return Category::all()->toArray();
    }

    public function store(StoreRequest $request): array
    {
        $category = Category::create($request->all());
        return $category->toArray();
    }

    public function show(string $categoryId): array
    {
        $category = Category::findOrFail($categoryId);
        return $category->toArray();
    }

    public function update(UpdateRequest $request, string $categoryId): array
    {
        $category = Category::findOrFail($categoryId);
        $category->fill($request->except('id'));

        if($category->isClean()) {
            return ['error' => 'At least one value must change', 'code' => 422];
        }

        $category->save();

        return $category->toArray();
    }

    public function destroy(string $id): array
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return $category->toArray();
    }
}