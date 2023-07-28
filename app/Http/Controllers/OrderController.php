<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    private CartService $cartService;
    private OrderService $orderService;

    public function __construct(CartService $cartService, OrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }

    public function index(): JsonResponse
    {
        $orders = $this->orderService->getUserOrders(Auth::id());
        return response()->json(OrderResource::collection($orders), Response::HTTP_OK);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $cart = $this->cartService->getUserCart(Auth::id());
            $cartItems = $cart->cartItems;
            $order = $this->orderService->createOrder(Auth::id(), $cart->id, $cartItems);
            $this->orderService->createOrderItems($order->id, $cartItems);

            $this->cartService->clearCartItems($cart);
            return response()->json(new OrderResource($order), Response::HTTP_CREATED);
        } catch(\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }


    public function show(string $id): JsonResponse
    {
        try {
            $order = $this->orderService->getOrder($id);
            return response()->json(new OrderResource($order), Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $order = $this->orderService->updateOrder($id, $request->all());
            return response()->json(new OrderResource($order), Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
       
    }

    public function destroy(string $id): JsonResponse
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return response()->json(new OrderResource($order), Response::HTTP_CREATED);
    }
}


