<?php

declare(strict_types=1);

namespace Domain\Sales\States;

class Pending extends SalesState
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
        return 'Sale is pending';
    }
}
