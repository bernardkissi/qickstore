<?php

declare(strict_types=1);

namespace App\Domains\Orders\States;

use Spatie\ModelStates\Attributes\AllowTransition;
use Spatie\ModelStates\Attributes\DefaultState;
use Spatie\ModelStates\State;

#[
    AllowTransition(Pending::class, Paid::class),
    AllowTransition(Pending::class, Failed::class),
    AllowTransition(Paid::class, Delivered::class),
    AllowTransition([Paid::class, Delivered::class], Refunded::class),
    DefaultState(Pending::class),
]

abstract class OrderState extends State
{
    /**
     * Returns the state of an order
     *
     * @return string
     */
    abstract public function status(): string;
}
