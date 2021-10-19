<?php

declare(strict_types=1);

namespace Domain\Sales\States;

class Ended extends SalesState
{
    /**
     * Property name of this state in DB
     *
     * @var string
     */
    public static $name = 'ended';

    /**
     * Returns the paid state of an order
     *
     * @return string
     */
    public function status(): string
    {
        return 'Sale has Ended';
    }
}
