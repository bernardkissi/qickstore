<?php

declare(strict_types=1);

namespace App\Domains\Orders\States;

class Shipped extends OrderState
{
    /**
     * Property name of this state in DB
     *
     * @var string
     */
    public static $name = 'shipped';

    /**
     * Returns the paid state of an order
     *
     * @return string
     */
    public function status(): string
    {
        return 'Shipped';
    }
}
