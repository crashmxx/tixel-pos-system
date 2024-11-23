<?php
namespace App\Services;

use App\Events\OrderStatusUpdated;
use App\Models\Order;

class OrderService
{
    public function updateStatus(Order $order, int $status): void
    {
        $order->update(['status' => $status]);

        OrderStatusUpdated::dispatch($order);
    }
}
