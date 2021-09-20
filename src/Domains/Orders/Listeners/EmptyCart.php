<?php

namespace Domain\Orders\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;

class EmptyCart implements ShouldQueue
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
        $event->order->orderable->cart()->detach();
    }
}
