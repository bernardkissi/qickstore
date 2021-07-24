<?php

declare(strict_types=1);

namespace App\Domains\Delivery\States;

class PickingUp extends DeliveryState
{
    /**
     * Property name of this state in DB
     *
     * @var string
     */
    public static $name = 'Pickingup';

    /**
     * Returns the paid state of an order
     *
     * @return string
     */
    public function status(): string
    {
        return 'Picking up';
    }
}
