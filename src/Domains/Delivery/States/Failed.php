<?php

declare(strict_types=1);

namespace Domain\Delivery\States;

class Failed extends DeliveryState
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
        return 'failed';
    }
}
