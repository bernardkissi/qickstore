<?php

declare(strict_types=1);

namespace App\Domains\Delivery\States;

class Assigned extends DeliveryState
{
    /**
     * Property name of this state in DB
     *
     * @var string
     */
    public static $name = 'assigned';

    /**
     * Returns the paid state of an order
     *
     * @return string
     */
    public function status(): string
    {
        return 'assigned';
    }
}
