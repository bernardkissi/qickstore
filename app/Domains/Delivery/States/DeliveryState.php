<?php

declare(strict_types=1);

namespace App\Domains\Delivery\States;

use App\Domains\Delivery\Transitions\WaitingToBeShippedToFailed;
use Spatie\ModelStates\Attributes\AllowTransition;
use Spatie\ModelStates\Attributes\DefaultState;
use Spatie\ModelStates\State;

#[
    AllowTransition(WaitingToBeShipped::class, Dispatched::class),
    AllowTransition(WaitingToBeShipped::class, Failed::class, WaitingToBeShippedToFailed::class),
    AllowTransition(WaitingToBeShipped::class, Completed::class),
    AllowTransition(Dispatched::class, Completed::class),
    DefaultState(WaitingToBeShipped::class),
]

abstract class DeliveryState extends State
{
    /**
     * Returns the state of an order
     *
     * @return string
     */
    abstract public function status(): string;
}
