<?php

declare(strict_types=1);

namespace Domain\Delivery\States;

class PickedUp extends DeliveryState
{
    /**
     * Property name of this state in DB
     *
     * @var string
     */
    public static $name = 'pickedup';

    /**
     * Returns the paid state of an order
     *
     * @return string
     */
    public function status(): string
    {
        return 'pickedup';
    }
}
