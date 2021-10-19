<?php

declare(strict_types=1);

namespace Domain\Orders\Actions;

use Domain\Orders\Checkouts\Facade\Checkout;
use Domain\Orders\Events\OrderCreatedEvent;
use Domain\Orders\Order;
use Illuminate\Support\Facades\DB;

class OrderCheckout
{
    public static function checkout(array $data): Order|string|null
    {
        $response = null;

        DB::transaction(function () use ($data, &$response) {
            $order = Checkout::createOrder($data);

            $payload = array_merge(['id' => $order->id, 'total' => $order->total], $data);
            $payment = Checkout::payOrder($payload);

            if (!$payment) {
                $response = $order;
            }

            if ($payment) {
                $response = $payment['data']['authorization_url'];
            }

            event(new OrderCreatedEvent($order, $payment));
        });

        return $response;
    }
}
