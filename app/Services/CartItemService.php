<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartItemService
{
    public function store(int $cartId, int $productId, int $productQty, float $amount): array
    {
        try {
            return DB::transaction(function() use ($cartId, $productId, $productQty, $amount) {
                $cartItem = CartItem::create([
                    'cart_id' => $cartId,
                    'product_id' => $productId,
                    'product_qty' => $productQty,
                    'amount' => $amount,
                ]);
                return $cartItem->toArray();
            });
        } catch(\Exception $e) {
            throw new \Exception('Error al crear el producto: ' . $e->getMessage());
        }
    }

    public function getCartItemToShow(string $cartId, string $productId): array
    {
        try {
            return DB::transaction(function() use ($cartId, $productId) {
                $cartItem = $this->getCartItem($cartId, $productId);
                return $cartItem->toArray();
            });
        } catch(\Exception $e) {
            throw new \Exception('Error al obtener el producto: ' . $e->getMessage());
        }
    }

    public function getCartItem(string $cart_id, string $product_id): CartItem | null
    {
        try {
            return DB::transaction(function() use ($cart_id, $product_id) {
                return CartItem::where('cart_id', $cart_id)->where('product_id', $product_id)->first();
            });
        } catch(\Exception $e) {
            throw new \Exception('Error al obtener el producto: ' . $e->getMessage());
        }
    }

    public function increaseItem(CartItem $cartItem, int $productQty): void
    {
        if (!$cartItem) {
            throw new \Exception('The product is not in the cart.');
        }

        try {
            DB::transaction(function() use ($cartItem, $productQty){
                $cartItem->product_qty += $productQty;
                $cartItem->amount = $cartItem->product_qty * $cartItem->product->price;
                $cartItem->save();
            });
        } catch(\Exception $e) {
            throw new \Exception('Error al sumar las unidades del producto: ' . $e->getMessage());
        }
    }

    public function decreaseItem(CartItem $cartItem, $producQty): void
    {

        if (!$cartItem) {
            throw new \Exception('The product is not in the cart.');
        }

        if ($cartItem->product_qty - $producQty < 0) {
            throw new \Exception('Cannot reduce product quantity below zero.');
        }

        try {
            DB::transaction(function() use ($cartItem, $producQty){
                $cartItem->product_qty -= $producQty;
                $cartItem->amount = $cartItem->product_qty * $cartItem->product->price;

                if ($cartItem->product_qty == 0) {
                    $cartItem->delete();
                } else {
                    $cartItem->save();
                }
            });
            
        } catch(\Exception $e) {
            throw new \Exception('Error al restar las unidades del producto: ' . $e->getMessage());
        }        
    }

    public function updateProductCartItemQty(CartItem $cartItem, Product $product, int $productQty): void
    {
        try {
            DB::transaction(function() use ($cartItem, $product, $productQty) {
                $cartItem->product_qty += $productQty;
                $cartItem->amount = $cartItem->product_qty * $product->price;
                $cartItem->save();
            });
        } catch(\Exception $e) {
            throw new \Exception('Error al actualizar las unidades del producto: ' . $e->getMessage());
        }
        
    }

    public function deleteCartItem(CartItem $cartItem): void
    {
        try{
            DB::transaction(function() use ($cartItem){
                $cartItem->delete();
            });
        }catch (\Exception $e){
            throw new \Exception('No se pudo eliminar el articulo: ' . $e->getMessage());
        }
    }
}
