<?php

declare(strict_types=1);

namespace App\Domains\Orders\Checkouts\Contract;

use App\Domains\Orders\Model\Order;

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
