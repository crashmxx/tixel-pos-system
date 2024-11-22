<?php

namespace Api;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_list_with_pagination()
    {
        // Arrange
        Order::factory(15)->create();

        // Act
        $response = $this->getJson('/api/orders?limit=5');

        // Assert
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'orders'=> [
                'data',
                'total'
            ],
            'statuses',
        ]);

        $this->assertCount(5, $response->json('orders.data'));
        $this->assertEquals(15, $response->json('orders.total'));
    }

    public function test_it_can_update_order_status()
    {
        // Arrange
        $order = Order::factory()->create(['status' => 0]);

        // Act
        $response = $this->patchJson("/api/orders/{$order->id}/status", [
            'status' => 2,
        ]);

        // Assert
        $response->assertStatus(200);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 2,
        ]);
    }
}
