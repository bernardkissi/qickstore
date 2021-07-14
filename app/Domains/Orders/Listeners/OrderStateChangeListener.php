<?php

namespace App\Domains\Orders\Listeners;

use App\Domains\Orders\Handlers\Processors\CompletedProcessor;
use App\Domains\Orders\Handlers\Processors\DeliveryProcessor;
use App\Domains\Orders\Handlers\Processors\FailedProcessor;
use App\Domains\Orders\Handlers\Processors\PaidProcessor;
use App\Domains\Orders\Handlers\Processors\RunProcess;
use Illuminate\Contracts\Queue\ShouldQueue;
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
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     *
     * @return void
     */
    public function handle(StateChanged $event)
    {
        $state = strval($event->finalState);

        $processor = match ($state) {
            'paid' => new PaidProcessor(),
            'failed' => new FailedProcessor(),
            'delivered' => new DeliveryProcessor(),
            'completed' => new CompletedProcessor(),
        };

        echo(RunProcess::run($processor));
    }
}
