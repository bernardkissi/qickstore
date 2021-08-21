<?php

declare(strict_types=1);

namespace App\Domains\Orders\Actions;

use App\Domains\Cart\Facade\Cart;
use App\Domains\Orders\Checkouts\Facade\Checkout;
use App\Domains\Orders\Events\OrderCreatedEvent;
use App\Domains\Orders\States\Delivered;
use App\Domains\Orders\States\Failed;
use App\Domains\Orders\States\Paid;
use App\Domains\Payments\Facade\Payment;

class OrderActions
{
    public function checkout(array $data)
    {
        Cart::user()->sync();

        if (Cart::user()->isEmpty()) {
            return response(['message' => 'Your cart is empty'], 400);
        }
        $order = Checkout::createOrder($data);

        $order->status()->create([]);

        //// $payment = Payment::charge($data);

        event(new OrderCreatedEvent($order));

        ////dd($payment);
    }


    public function show()
    {
    }
}
