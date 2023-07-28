<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected OrderItemService $orderItemService;
    
    public function __construct(OrderItemService $orderItemService)
    {
        $this->orderItemService = $orderItemService;
    }

    public function getUserOrders(int $userId): Collection
    {
        try {
            return DB::transaction(function () use ($userId) {
                $orders = Order::where('user_id', $userId)->get();
                return $orders;
            });
        } catch (\Exception $e) {
            return "No se pudo octener las ordernes del usuario: " . $e->getMessage();
        }
    }

   

    // public function placeOrder($cart, $request)
    // {
    //     $order = $this->orderRepository->createOrder($request->all());
    //     $this->orderItemRepository->createOrderItems($order, $cart);
    //     $this->cartItemRepository->deleteCartItems($cart);
    //     $this->cartRepository->deleteCart($cart);

    //     return $order;
    // }

    public function createOrder(int $userId, int $cartId, Collection $cartItems): Order
    {

        $totalAmount = $cartItems->sum(function ($item) {
            return $item->product_qty * $item->product->price;
        });
        
        try {
            return DB::transaction(function () use ($userId, $cartId, $totalAmount) {
                $order = Order::create([
                    'user_id' => $userId,
                    'cart_id' => $cartId,
                    'total_amount' => $totalAmount,
                ]);

                return $order;
            });
        } catch (\Exception $e) {
            throw new \Exception("No se pudo crear la orden: " . $e->getMessage());
        }
    }

    public function createOrderItems(int $orderId, Collection $cartItems): void
    {
        try {
            DB::transaction(function () use ($orderId, $cartItems) {
                foreach ($cartItems as $cartItem) {
                    $this->orderItemService->createOrderItem($orderId, $cartItem);
                }
            });
        } catch (\Exception $e) {
            throw new \Exception("No se pudo crear los items de la orden: " . $e->getMessage());
        }
    }

    public function getOrder(int $orderId): Order
    {
        try {
            return DB::transaction(function () use ($orderId) {
                $order = Order::findOrFail($orderId)->with('orderItems')->first();
                return $order;
            });
        } catch (\Exception $e) {
            throw new \Exception("No se pudo obtener la orden: " . $e->getMessage());
        }
    }

    public function updateOrder(int $orderId, array $data): Order
    {
        try {
            return DB::transaction(function () use ($orderId, $data) {
                $order = Order::findOrFail($orderId);
                $order->fill($data);
                if($order->isClean()) {
                    throw new \Exception('At least one value must change');
                }
                $order->save();
            });
        } catch (\Exception $e) {
            throw new \Exception("No se pudo actualizar la orden: " . $e->getMessage());
        }
    }

    public function deleteOrder($id): void 
    {
        try {
            DB::transaction(function () use ($id) {
                $order = Order::findOrFail($id);
                $order->delete();
            });
        } catch (\Exception $e){
            throw new \Exception("No se pudo eliminar la orden: " . $e->getMessage());
        }
    }

    public function markOrderAsPaid(Order $order): void
    {
        try {
            $this->updateOrderStatus($order, Order::ORDER_PAID);
        } catch(\Exception $e) {
            throw new \Exception("No se pudo actualizar el estado de la orden: " . $e->getMessage());
        }
    }

    public function markOrderAsShipped(Order $order): void
    {
        try {
            $this->updateOrderStatus($order, Order::ORDER_SHIPPED);
        } catch(\Exception $e) {
            throw new \Exception("No se pudo actualizar el estado de la orden: " . $e->getMessage());
        }
    }

    public function markOrderAsDelivered(Order $order): void
    {
        try {
            $this->updateOrderStatus($order, Order::ORDER_DELIVERED);
        } catch(\Exception $e) {
            throw new \Exception("No se pudo actualizar el estado de la orden: " . $e->getMessage());
        }
    }

    public function markOrderAsCancelled(Order $order): void
    {
        try {
            $this->updateOrderStatus($order, Order::ORDER_CANCELLED);
        } catch(\Exception $e) {
            throw new \Exception("No se pudo actualizar el estado de la orden: " . $e->getMessage());
        }
    }

    private function updateOrderStatus(Order $order, string $status): void
    {
        try {
            DB::transaction(function () use ($order, $status) {
                $order->status = $status;
                $order->save();
            });
        } catch(\Exception $e) {
            throw new \Exception("No se pudo actualizar el estado de la orden: " . $e->getMessage());
        }
    }
}
