<?php

namespace App\Domains\Orders\Checkouts\Services;

use App\Domains\Cart\Services\Cart;
use App\Domains\Orders\Checkouts\Contract\CheckoutableProvider;
use App\Domains\Orders\Model\Order;
use App\Domains\User\User;
use App\Domains\User\Visitor;

class CheckoutService implements CheckoutableProvider
{

    /**
     * Class constructor
     *
     * @param mixed $customer
     */
    public function __construct(public User|Visitor $customer)
    {
    }


    public function createOrder(Cart $cart): Order
    {
        $order = $this->customer->orders()->create(['subtotal' => $cart->total()->getAmount()]);
        $order->products()->sync($this->cart->products()->toCollect());
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
