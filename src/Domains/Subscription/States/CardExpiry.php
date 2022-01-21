<?php

declare(strict_types=1);

namespace Domain\Subscription\States;

class CardExpiry extends SubscriptionState
{
    /**
     * Property name of this state in DB
     *
     * @var string
     */
    public static $name = 'card-expiry';

    /**
     * Returns the paid state of an order
     *
     * @return string
     */
    public function status(): string
    {
        return 'Subscription payment card is expirying';
    }
}
