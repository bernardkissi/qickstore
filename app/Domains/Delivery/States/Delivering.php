<?php

declare(strict_types=1);

namespace App\Domains\Delivery\States;

class Delivering extends DeliveryState
{
    /**
     * Property name of this state in DB
     *
     * @var string
     */
    public static $name = 'delivering';

    /**
     * Returns the paid state of an order
     *
     * @return string
     */
    public function status(): string
    {
        return 'delivering';
    }
}
