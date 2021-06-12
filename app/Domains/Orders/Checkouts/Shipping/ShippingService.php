<?php

declare(strict_types=1);

namespace App\Domains\Orders\Checkouts\Shipping;

use App\Domains\Cart\Services\Cart;
use App\Domains\Orders\Checkouts\CheckOutService;
use App\Domains\Orders\Checkouts\Shipping\ShippableContract;
use App\Domains\Orders\Model\Order;
use App\Domains\User\User;
use App\Domains\User\Visitor;

class ShippingService extends CheckOutService implements ShippableContract
{

     /**
     * Class constructor
     *
     * @param mixed $customer
     */
    public function __construct(public User|Visitor $customer)
    {
    }

    /**
     * Persit user order into datastore
     *
     * @return void
     */
    public function createOrder(Cart $cart): Order
    {
        $order = $this->customer->orders()->create(['subtotal' => $cart->subTotal()->getAmount() + 10]);
        $order->products()->sync($cart->products()->toCollect());
        return $order;
    }

    /**
     * Runs payment for the pending order
     *
     * @return string
     */
    public function payOrder(): string
    {
        return 'paying for shipping order ....';
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function dispatchOrder(): string
    {
        return 'dispatching order ..';
    }

    /**
    * Create shippment for order
    *
    * @return void
    */
    public function delivery(): string
    {
        return 'dispatching order ..';
    }
}
