<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddItemToCartRequest;
use App\Http\Requests\MergeCartsRequest;
use App\Http\Requests\RemoveFromCartRequest;
use App\Http\Requests\UpdateCartItemQuantityRequest;
use App\Services\CartItemService;
use App\Services\CartPreparationService;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private $cartItemService;
    private $cartService;
    private $cartPreparationService;

    public function __construct(CartItemService $cartItemService, CartService $cartService, CartPreparationService $cartPreparationService)
    {
        $this->cartItemService = $cartItemService;
        $this->cartService = $cartService;
        $this->cartPreparationService = $cartPreparationService;
    }

    public function addItemToCart(AddItemToCartRequest $request): JsonResponse
    {
        try {
            [$cart, $product, $cartItem] = ($this->cartPreparationService)($request->product_id);

            if($cartItem) {
                $this->cartItemService->increaseItem($cartItem['id'], $request->product_qty);
            } else {
                $this->cartItemService->store($cart['id'], $product->id, $request->product_qty, $product->price * $request->product_qty);
            }

            return response()->json([
                'message' => 'Product added to cart successfully.',
            ], Response::HTTP_CREATED);
        } catch(\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function removeFromCart(RemoveFromCartRequest $request): JsonResponse
    {
        try {
            [$cart, $product, $cartItem] = ($this->cartPreparationService)($request->product_id);

            if(!$cartItem) {
                return response()->json(['message' => 'This product is not in your cart.']);
            }

            $this->cartItemService->deleteCartItem($cartItem);

            return response()->json(['message' => 'Product removed from cart successfully.']);
        } catch(\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateCartItemQuantity(UpdateCartItemQuantityRequest $request): JsonResponse
    {
        try {
            [$cart, $product, $cartItem] = ($this->cartPreparationService)($request->product_id);;

            if(!$cartItem) {
                return response()->json(['message' => 'This product is not in your cart.']);
            }

            $this->cartItemService->updateProductCartItemQty($cartItem, $product, $request->product_qty);

            return response()->json(['message' => 'Cart item quantity updated successfully.']);
        } catch(\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getCartItems(Request $request): JsonResponse
    {
        try {
            $cart = $this->cartService->FindOrCreateCart(Auth::id());
            $cartItems = $this->cartService->getCartItems($cart);
            return response()->json(['cart_items' => $cartItems]);
        } catch(\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function clearCart(Request $request): JsonResponse
    {
        $cart = $this->cartService->FindOrCreateCart(Auth::id());

        if(!$cart) {
            return response()->json(['message' => 'No se encontró un carrito para este usuario.']);
        }

        $this->cartService->clearCartItems($cart);

        return response()->json(['message' => 'Cart cleared successfully.']);
    }

    public function mergeCarts(MergeCartsRequest $request): JsonResponse
    {
        try {
            $user_id = Auth::id();
            $cart = $this->cartService->FindOrCreateCart($user_id);

            foreach($request->items as $item) {
                $existingItem = $this->cartItemService->getCartItem($cart->id, $item['product_id']);

                if($existingItem) {
                    $this->cartItemService->increaseItem($existingItem->id, $item['product_qty']);
                } else {
                    $this->cartItemService->store($cart->id, $item['product_id'], $item['product_qty'], $item['product_qty'] * $item['amount']);
                }
            }

            return response()->json(['message' => 'Carritos fusionados con éxito.']);
        } catch(\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
