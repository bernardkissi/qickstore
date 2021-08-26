<?php

namespace Domain\Payouts\Listeners;

class PayoutNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     *
     * @return void
     */
    public function handle($event)
    {
        echo json_encode($event->merchant);
    }
}
