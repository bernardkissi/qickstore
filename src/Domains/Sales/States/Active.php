<?php

declare(strict_types=1);

namespace Domain\Sales\States;

class Active extends SalesState
{
    /**
     * Property name of this state in DB
     *
     * @var string
     */
    public static $name = 'active';

    /**
     * Returns the paid state of an order
     *
     * @return string
     */
    public function status(): string
    {
        return 'Sale is active';
    }
}
