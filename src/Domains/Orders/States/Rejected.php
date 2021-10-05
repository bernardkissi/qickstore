<?php

declare(strict_types=1);

namespace Domain\Orders\States;

class Rejected extends OrderState
{
    /**
     * Property name of this state in DB
     *
     * @var string
     */
    public static $name = 'rejected';

    /**
     * Returns the rejected status state of an order
     *
     * @return string
     */
    public function status(): string
    {
        return 'Disputed is rejected by seller';
    }
}
