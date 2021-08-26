<?php

namespace Domain\Orders\Checkouts\Services;

use Domain\Cart\Facade\Cart;
use Domain\Orders\Checkouts\Contract\CheckoutableContract;
use Domain\Orders\Order;
use Domain\User\User;
use Domain\User\Visitor;

class CheckoutService implements CheckoutableContract
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
                'subtotal' => Cart::user()->total()->getAmount(),
                'service' => 'tracktry-logistics',
                'something' => 'something'
            ]
        );
        $order->products()->sync(Cart::user()->products()->toCollect());
        return $order;
    }

    /**
     * Runs payment for the pending order
     *
     * @return string
     */
    public function payOrder(): string
    {
        return 'Are ready to pay for order? ....';
    }
}
