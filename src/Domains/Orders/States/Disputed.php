<?php

declare(strict_types=1);

namespace Domain\Orders\States;

class Disputed extends OrderState
{
    /**
     * Property name of this state in DB
     *
     * @var string
     */
    public static $name = 'disputed';

    /**
     * Returns the paid state of an order
     *
     * @return string
     */
    public function status(): string
    {
        return 'Disputed';
    }
}
