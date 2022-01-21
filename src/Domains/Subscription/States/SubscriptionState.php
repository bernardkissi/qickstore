<?php

declare(strict_types=1);

namespace Domain\Subscription\States;

use Spatie\ModelStates\Attributes\AllowTransition;
use Spatie\ModelStates\Attributes\DefaultState;
use Spatie\ModelStates\State;

#[
    AllowTransition(Pending::class, Active::class),
    AllowTransition(Pending::class, PaymentFailed::class),
    AllowTransition(Active::class, CardExpiry::class),
    AllowTransition(Active::class, Disabled::class),
    AllowTransition(Active::class, NotRenewing::class),
    AllowTransition(NotRenewing::class, Active::class),
    AllowTransition(Active::class, PaymentFailed::class),
    AllowTransition(PaymentFailed::class, Active::class),
    AllowTransition(Disabled::class, Active::class),
    DefaultState(Active::class),
]

abstract class SubscriptionState extends State
{
    /**
     * Returns the state of an order
     *
     * @return string
     */
    abstract public function status(): string;
}
