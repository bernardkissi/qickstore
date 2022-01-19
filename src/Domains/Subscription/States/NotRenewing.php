<?php

declare(strict_types=1);

namespace Domain\Subscription\States;

class NotRenewing extends SubscriptionState
{
    /**
     * Property name of this state in DB
     *
     * @var string
     */
    public static $name = 'not-renewing';

    /**
     * Returns the paid state of an order
     *
     * @return string
     */
    public function status(): string
    {
        return 'Subscription is not renewing';
    }
}
