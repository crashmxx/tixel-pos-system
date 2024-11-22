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
        Order::factory(15)->create();

        $response = $this->getJson('/api/orders?limit=5');
        $response->assertStatus(200);
        $response->dump();
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
}
