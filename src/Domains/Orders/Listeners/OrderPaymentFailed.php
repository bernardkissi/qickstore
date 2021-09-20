<?php

namespace Domain\Orders\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;

class OrderPaymentFailed implements ShouldQueue
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
        //transistion with reason to failed
    }
}
