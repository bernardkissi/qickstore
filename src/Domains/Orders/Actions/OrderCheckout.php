<?php

declare(strict_types=1);

namespace Domain\Orders\Actions;

use Domain\Orders\Checkouts\Facade\Checkout;
use Domain\Orders\Events\OrderCreatedEvent;
use Domain\Payments\Facade\Payment;
use Illuminate\Support\Facades\DB;

class OrderCheckout
{
    /**
     * checkout users order
     *
     * @param array $data
     * @return void
     */
    public static function checkout(array $data): string|null
    {
        $url = null;

        DB::transaction(function () use ($data, &$url) {
            $order = Checkout::createOrder($data);
            $payload = array_merge(['id' => $order->id], $data);

            $payment = Payment::Charge($payload);
            event(new OrderCreatedEvent($order, $payment));
            $url = $payment['data']['authorization_url'];
        });

        return $url;
    }
}
