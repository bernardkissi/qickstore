<?php

namespace Domain\Orders\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;

class OrderPaymentSuccessful implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     *
     * @return void
     */
    public function handle($event)
    {
        // create payment transaction
        // transition to paid
    }
}
