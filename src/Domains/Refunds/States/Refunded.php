<?php

declare(strict_types=1);

namespace Domain\Refunds\States;

use Domain\Refunds\States\RefundState;

class Refunded extends RefundState
{
    /**
     * Property name of this state in DB
     *
     * @var string
     */
    public static $name = 'refunded';

    /**
     * Returns the paid state of an order
     *
     * @return string
     */
    public function status(): string
    {
        return 'Your order has been refunded';
    }
}
