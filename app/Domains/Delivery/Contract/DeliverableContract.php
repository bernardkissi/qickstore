<?php

namespace App\Domains\Delivery\Contract;

use App\Domains\Orders\Model\Order;

interface DeliverableContract
{
    /**
     * Process delivery of the order
     *
     * @return void
     */

    public static function dispatch(Order $order): void;
}
