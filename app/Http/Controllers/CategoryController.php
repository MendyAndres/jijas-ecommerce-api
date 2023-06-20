<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\category\UpdateRequest;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService) {
        $this->categoryService = $categoryService;
    }
    
    public function index(): JsonResponse
    {
        return response()->json($this->categoryService->index());
    }

    
    public function store(StoreRequest $request): JsonResponse
    {
        $category = $this->categoryService->store($request);
        return response()->json($category, 201);
    }

    public function show(string $id)
    {
        return response()->json($this->categoryService->show($id));
    }

    public function update(UpdateRequest $request, string $categoryId)
    {
        $categoryResponse = $this->categoryService->update($request, $categoryId);
        
        if(isset($categoryResponse['error'])) {
            return response()->json(['error' => $categoryResponse['error'], 'code' => $categoryResponse['code']], $categoryResponse['code']);
        }

        return response()->json(['data' => $categoryResponse]);
    }

    public function destroy(string $categoryId)
    {
        return response()->json($this->categoryService->destroy($categoryId));
    }
}
