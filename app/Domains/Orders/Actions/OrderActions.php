<?php

declare(strict_types=1);

namespace App\Domains\Orders\Actions;

use App\Domains\Orders\States\Failed;
use App\Domains\Orders\States\Paid;
use App\Domains\User\User;
use App\Domains\User\Visitor;

class OrderActions
{
    public function __construct()
    {
    }

    public function createOrder()
    {
        $user = Visitor::find(1); // demo
        $order = $user->orders()->create(['subtotal' => 1000]);

        $order->state->transitionTo(Failed::class, 'this was an error');

        return [
            'currentState' => $order->state,
            'states' => $order->getStates(),
            'defzult' => $order->getDefaultStates(),
            'transitions' => $order->state->transitionableStates()
        ];
    }
}
