<?php

namespace App\Domains\Delivery\Contract;

use App\Domains\Orders\Model\Order;

interface DeliverableProviderContract
{
    /**
     * Process delivery of the order
     *
     * @return void
     */
    public function dispatch(): string;

    /**
     * Get the delivery information of the order
     *
     * @param Order $order
     * @return array
     */
    public function deliveryInfo(Order $order): array;
}
