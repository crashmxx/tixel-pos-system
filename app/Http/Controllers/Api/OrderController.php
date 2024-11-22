<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $limit = $request->input('limit', 10);
        $orders = Order::paginate($limit);

        $statusOptions = [];
        foreach (OrderStatus::cases() as $status) {
            $statusOptions[$status->value] = $status->name;
        }

        return response()->json([
                'orders' => $orders,
                'statuses' => $statusOptions,
            ]
        );
    }
}
