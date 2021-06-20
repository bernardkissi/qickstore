<?php

declare(strict_types=1);

namespace App\Domains\Delivery\States;

class Failed extends DeliveryState
{
    /**
     * Property name of this state in DB
     *
     * @var string
     */
    public static $name = 'Failed';

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
