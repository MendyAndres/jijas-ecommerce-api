<?php

namespace App\Http\Controllers;

use App\Http\Requests\Subcategory\StoreRequest;
use App\Http\Requests\Subcategory\UpdateRequest;
use App\Services\SubcategoryService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SubcategoryController extends Controller
{
    private $subcategoryService;

    public function __construct(SubcategoryService $subcategoryService)
    {
        $this->subcategoryService = $subcategoryService;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->subcategoryService->index());
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $subcategory = $this->subcategoryService->store($request);
        return response()->json($subcategory, 201);
    }

    public function show(string $id): JsonResponse
    {
        return response()->json($this->subcategoryService->show($id));
    }

    public function update(UpdateRequest $request, string $subcategoryId): JsonResponse
    {
        $subcategoryResponse = $this->subcategoryService->update($request, $subcategoryId);
        
        if(isset($subcategoryResponse['error'])) {
            return response()->json(['error' => $subcategoryResponse['error'], 'code' => $subcategoryResponse['code']], $subcategoryResponse['code']);
        }

        return response()->json(['data' => $subcategoryResponse]);
    }

    public function destroy(string $subcategoryId): JsonResponse
    {
        return response()->json($this->subcategoryService->destroy($subcategoryId));
    }
}
