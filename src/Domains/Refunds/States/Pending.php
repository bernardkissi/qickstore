<?php

declare(strict_types=1);

namespace Domain\Refunds\States;

class Pending extends RefundState
{
    /**
     * Property name of this state in DB
     *
     * @var string
     */
    public static $name = 'pending';

    /**
     * Returns the paid state of an order
     *
     * @return string
     */
    public function status(): string
    {
        return 'Your refund has been initiated';
    }
}
