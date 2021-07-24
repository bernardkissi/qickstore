<?php

declare(strict_types=1);

namespace App\Domains\Delivery\States;

class Delivered extends DeliveryState
{
    /**
     * Property name of this state in DB
     *
     * @var string
     */
    public static $name = 'Delivered';

    /**
     * Returns the paid state of an order
     *
     * @return string
     */
    public function status(): string
    {
        return 'Delivered';
    }
}
