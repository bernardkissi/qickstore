<?php

declare(strict_types=1);

namespace App\Domains\Orders\Actions;

use App\Domains\Orders\States\Failed;
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
            'transitions' => $order->state->transitionableStates(),
        ];
    }
}

//creating orders
// 1. sync items in cart with quantity
// 2. check if the the cart is not empty
// 3. get items from cart
// 4. create the order -- set the transition state to pending
// make payment of the order -- after the webhook response we set order to state of paid

//jobs behind the scene

//OnPaid
//1. Empty the cart of the user or visitior
//2. sent an SMS/Voice to the seller.
//3. Sent an email/SMS to the buyer with tracking code
//4. A delivery is made to the swoove delivery network -- create a delivery table to handle this with status

//OnFailed
// they buyer is alerted on failure of order
// we log the reason on failure on the order
// buyer can retry the order on a signed url with ttl set

//onDelivery
// We alert user everystep on the way
// From pickup to drop off

//OnCompleted
// we send a satisfaction message for store rating // anyway we can improve our service
// And finally we dispatch the funds to the buyer.
