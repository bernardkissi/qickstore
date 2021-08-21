<?php

namespace App\Domains\Orders\Checkouts\Services;

use App\Domains\Cart\Facade\Cart;
use App\Domains\Orders\Checkouts\Contract\CheckoutableContract;
use App\Domains\Orders\Model\Order;
use App\Domains\User\User;
use App\Domains\User\Visitor;

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
