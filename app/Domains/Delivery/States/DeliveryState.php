<?php

declare(strict_types=1);

namespace App\Domains\Delivery\States;

use App\Domains\Delivery\Transitions\WaitingToBeShippedToFailed;
use Spatie\ModelStates\Attributes\AllowTransition;
use Spatie\ModelStates\Attributes\DefaultState;
use Spatie\ModelStates\State;

#[
    AllowTransition(Pending::class, Failed::class, WaitingToBeShippedToFailed::class),
    AllowTransition(Pending::class, Delivered::class),
    AllowTransition([Assigned::class, PickingUp::class], PickedUp::class),
    AllowTransition([PickedUp::class, Delivering::class], Delivered::class),
    AllowTransition([PickingUp::class, Delivering::class], Failed::class, WaitingToBeShippedToFailed::class),
    DefaultState(Pending::class),
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
