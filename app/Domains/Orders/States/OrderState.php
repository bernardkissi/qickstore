<?php

declare(strict_types=1);

namespace App\Domains\Orders\States;

use App\Domains\Orders\Transitions\PendingToFailed;
use Spatie\ModelStates\Attributes\AllowTransition;
use Spatie\ModelStates\Attributes\DefaultState;
use Spatie\ModelStates\State;

#[
    AllowTransition(Pending::class, Paid::class),
    AllowTransition(Pending::class, Cancelled::class),
    AllowTransition(Pending::class, Failed::class, PendingToFailed::class),
    AllowTransition(Failed::class, Paid::class),
    AllowTransition(Paid::class, Shipped::class),
    AllowTransition(Paid::class, Delivered::class),
    AllowTransition(Shipped::class, Delivered::class),
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
