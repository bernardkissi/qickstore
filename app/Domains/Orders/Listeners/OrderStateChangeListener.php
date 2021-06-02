<?php

namespace App\Domains\Orders\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\ModelStates\Events\StateChanged;

class OrderStateChangeListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(StateChanged $event)
    {
        echo  $event->initialState . ' --- ' . $event->finalState;
    }
}
