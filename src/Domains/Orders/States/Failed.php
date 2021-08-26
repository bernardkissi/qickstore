<?php

declare(strict_types=1);

namespace Domain\Orders\States;

use Domain\Orders\States\OrderState;

class Failed extends OrderState
{
    /**
     * Property name of this state in DB
     *
     * @var string
     */
    public static $name = 'failed';

    /**
     * Returns the paid state of an order
     *
     * @return string
     */
    public function status(): string
    {
        return 'Failed';
    }
}
