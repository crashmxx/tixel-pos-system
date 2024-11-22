<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function show(int $orderId): JsonResponse
    {
        $order = Order::findOrFail($orderId);
        return response()->json([
            'order' => $order,
        ]);
    }
}
