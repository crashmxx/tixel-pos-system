<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    /** @test */
    public function it_can_show_order_status()
    {
        $order = Order::factory()->create([
            'status' => OrderStatus::COOKING->value,
        ]);
        $response = $this->getJson("/api/orders/{$order->id}");
        $response->assertStatus(200);
        $response->assertJson([
            'order' => [
                'id' => $order->id,
                'status' => $order->status,
            ],
        ]);
    }
}
