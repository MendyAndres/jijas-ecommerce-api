<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\ProductService;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(): JsonResponse
    {
        $products = $this->productService->index();
        return response()->json(['data' => $products]);
    }

    public function store(Request $request): JsonResponse
    {
        $product = $this->productService->store($request);
        return response()->json(['data' => $product], 201);
    }

    public function show(string $productId): JsonResponse
    {
        $product = $this->productService->show($productId);
        return response()->json(['data' => $product]);
    }

    public function update(Request $request, string $productId): JsonResponse
    {
        $productResponse = $this->productService->update($request, $productId);
        
        if(isset($productResponse['error'])) {
            return response()->json(['error' => $productResponse['error'], 'code' => $productResponse['code']], $productResponse['code']);
        }

        return response()->json(['data' => $productResponse]);
    }

    public function destroy(string $id): JsonResponse
    {
        $product = $this->productService->destroy($id);
        return response()->json(['data' => $product]);
    }
}
