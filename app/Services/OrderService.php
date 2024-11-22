<?php
namespace App\Services;

use App\Models\Order;

class OrderService
{
    public function updateStatus(Order $order, int $status): void
    {
        $order->update(['status' => $status]);

        // Broadcast an event to inform clients about the update (WebSocket event)
        // @todo
    }
}
