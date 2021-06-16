<?php

declare(strict_types=1);

namespace App\Domains\Orders\Checkouts\Contract;

use App\Domains\Cart\Services\Cart;
use App\Domains\Orders\Model\Order;

interface CheckoutableProvider
{
    /**
     * Create customer order
     *
     * @return Order
     */
    public function createOrder(Cart $cart): Order;

    /**
     * Pay for the order
     *
     * @return string
     */
    public function payOrder(): string;
}
