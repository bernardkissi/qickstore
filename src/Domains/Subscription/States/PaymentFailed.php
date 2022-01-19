<?php

declare(strict_types=1);

namespace Domain\Subscription\States;

class PaymentFailed extends SubscriptionState
{
    /**
     * Property name of this state in DB
     *
     * @var string
     */
    public static $name = 'payment-failed';

    /**
     * Returns the paid state of an order
     *
     * @return string
     */
    public function status(): string
    {
        return 'Subscription payment failed';
    }
}
