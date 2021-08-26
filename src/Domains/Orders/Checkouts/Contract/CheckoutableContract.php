<?php

declare(strict_types=1);

namespace Domain\Orders\Checkouts\Contract;

use Domain\Orders\Order;

interface CheckoutableContract
{
    /**
     * Create customer order
     *
     * @return Order
     */
    public function createOrder(array $data): Order;

    /**
     * Pay for the order
     *
     * @return string
     */
    public function payOrder(): string;
}
