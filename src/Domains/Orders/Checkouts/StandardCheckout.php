<?php

declare(strict_types=1);

namespace Domain\Orders\Checkouts;

use Domain\Cart\Facade\Cart;
use Domain\Orders\Checkouts\Contract\Checkoutable;
use Domain\Orders\Order;
use Domain\Payments\Facade\Payment;
use Domain\User\User;
use Domain\User\Visitor;

class StandardCheckout implements Checkoutable
{
    /**
     * Class constructor
     *
     * @param mixed $customer
     */
    public function __construct(public User | Visitor $customer)
    {
    }

    public function createOrder(array $data): Order
    {
        $order = $this->customer->orders()->create(
            [
                'subtotal' => Cart::total()->getAmount(),
                'service' => 'tracktry-logistics',
                'something' => 'something',
            ]
        );
        $order->products()->sync(Cart::products()->toCollect());

        return $order;
    }

    /**
     * Runs payment for the pending order
     *
     * @return string
     */
    public function payOrder(?array $payload): ?array
    {
        return Payment::Charge($payload);
    }
}
