<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Services\OrderService;
use App\Services\OrderItemService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateOrder()
    {
        $user = User::factory()->create();
        $cart = Cart::factory()->create(['user_id' => $user->id]);
        CartItem::factory()->count(3)->create(['cart_id' => $cart->id]);

        $response = $this->actingAs($user)->postJson('/api/orders');

        $response->assertStatus(201);
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'status' => 'created',
        ]);
        $this->assertCount(3, OrderItem::all());
    }

    public function testGetUserOrders()
    {
        $user = User::factory()->create();
        Order::factory()->count(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson('/api/orders');

        $response->assertStatus(200);
        $this->assertCount(3, $response->json());
    }

    public function testGetOrderDetails()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);
        $oderItems = OrderItem::factory()->count(3)->create(['order_id' => $order->id]);

        $response = $this->actingAs($user)->getJson("/api/orders/{$order->id}");
        $response->assertStatus(200);
        $this->assertEquals($order->id, $response->json('id'));
        $this->assertCount(3, $response->json('items'));
    }

    public function testMarkOrderAsPaid()
    {
        $order = Order::factory()->create();

        $orderService = new OrderService(new OrderItemService());
        $orderService->markOrderAsPaid($order);
        
        $this->assertEquals('paid', $order->status);
    }
}
