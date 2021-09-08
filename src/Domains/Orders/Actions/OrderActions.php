<?php

declare(strict_types=1);

namespace Domain\Orders\Actions;

use Domain\Cart\Facade\Cart;
use Domain\Orders\Checkouts\Facade\Checkout;
use Domain\Orders\Events\OrderCreatedEvent;
use Domain\Payments\Facade\Payment;
use Illuminate\Support\Facades\DB;

class OrderActions
{
    public function checkout(array $data)
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
