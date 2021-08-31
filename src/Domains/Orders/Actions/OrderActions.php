<?php

declare(strict_types=1);

namespace App\Domains\Orders\Actions;

use Domain\Cart\Facade\Cart;
use Domain\Orders\Checkouts\Facade\Checkout;
use Domain\Orders\Events\OrderCreatedEvent;

class OrderActions
{
    public function checkout(array $data)
    {
        Cart::user()->sync();

        if (Cart::user()->isEmpty()) {
            return response(['message' => 'Your cart is empty'], 400);
        }
        $order = Checkout::createOrder($data);

        event(new OrderCreatedEvent($order));
    }


    public function show()
    {
    }
}
