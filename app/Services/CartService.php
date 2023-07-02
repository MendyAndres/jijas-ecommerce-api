<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartService
{
    public function FindOrCreateCart(int $userId): Cart
    {
        try {
            return DB::transaction(function() use ($userId) {
                return Cart::firstOrCreate([ 'user_id' => $userId ]);
            });
        } catch (\Exception $e) {
            throw new \Exception('Error al crear el carrito: ' . $e->getMessage());
        }
    }

    public function getCartItems(Cart $cart): array
    {
        try {
            return DB::transaction(function() use ($cart) {
                return $cart->cartItems()->with('product')->get()->toArray();
            });
        } catch(\Exception $e) {
            throw new \Exception('Error al obtener los productos del carrito: ' . $e->getMessage());
        }

    }

    public function clearCartItems(Cart $cart): void
    {
        try {
            DB::transaction(function() use ($cart) {
                $cart->cartItems()->delete();
            });
        } catch(\Exception $e) {
            throw new \Exception('Error al limpiar el carrito: ' . $e->getMessage());
        }
    }
}
