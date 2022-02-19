<?php

declare(strict_types=1);

namespace Domain\Subscription\States;

class Disabled extends SubscriptionState
{
    /**
     * Property name of this state in DB
     *
     * @var string
     */
    public static $name = ' cancelled';

    /**
     * Returns the paid state of an order
     *
     * @return string
     */
    public function status(): string
    {
        return 'Subscription is cancelled';
    }
}
