<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderItemService
{
    public function createOrderItem(string $orderId, CartItem $cartItem): OrderItem
    {
        try{
            return DB::transaction(function() use($orderId, $cartItem){
                return OrderItem::create([
                    'order_id' => $orderId,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->product_qty,
                    'price' => $cartItem->product->price,
                ]);
            });
        } catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
        
    }
}