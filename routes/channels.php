<?php

use App\Models\Order;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('App.Models.Order.{id}', function ($orderId, $data) {
    $order = Order::find($orderId);

    if (!$order) {
        return false;
    }
    return $data['access_token'] === $order->access_token &&
        $order->access_token_expires_at &&
        !$order->access_token_expires_at->isPast();
});
