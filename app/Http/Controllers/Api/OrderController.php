<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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

    public function updateStatus(Request $request, Order $order, OrderService $orderService): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(array_keys(OrderStatus::cases()))]
        ]);

        $orderService->updateStatus($order, $validated['status']);

        return response()->json([
            'success' => true,
            'message' => __('Order status updated successfully.'),
        ]);
    }
}
