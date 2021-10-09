<?php

declare(strict_types=1);

namespace Domain\Disputes\States;

use Spatie\ModelStates\Attributes\AllowTransition;
use Spatie\ModelStates\Attributes\DefaultState;
use Spatie\ModelStates\State;

#[
    AllowTransition(Open::class, Declined::class),
    AllowTransition(Open::class, Accepted::class),
    AllowTransition(Accepted::class, Resolved::class),
    DefaultState(Open::class),
]

abstract class DisputeState extends State
{
    /**
     * Returns the state of an order
     *
     * @return string
     */
    abstract public function status(): string;
}
