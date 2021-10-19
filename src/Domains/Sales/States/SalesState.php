<?php

declare(strict_types=1);

namespace Domain\Sales\States;

use Spatie\ModelStates\Attributes\AllowTransition;
use Spatie\ModelStates\Attributes\DefaultState;
use Spatie\ModelStates\State;

#[
    AllowTransition(Pending::class, Active::class),
    AllowTransition(Pending::class, Cancelled::class),
    AllowTransition(Active::class, Paused::class),
    AllowTransition(Active::class, Ended::class),
    DefaultState(Pending::class),
]
abstract class SalesState extends State
{
    /**
     * Returns the state of an order
     *
     * @return string
     */
    abstract public function status(): string;
}
