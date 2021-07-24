<?php

namespace App\Domains\Orders\Listeners;

use App\Core\Helpers\Processor\RunProcessor;
use App\Domains\Orders\Processors\CompletedProcessor;
use App\Domains\Orders\Processors\DeliveryProcessor;
use App\Domains\Orders\Processors\FailedProcessor;
use App\Domains\Orders\Processors\PaidProcessor;
use App\Domains\Orders\Processors\ShippedProcessor;
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
            'paid' => new PaidProcessor($event->model),
            'failed' => new FailedProcessor($event->model),
            'shipped' => new ShippedProcessor($event->model),
            'delivered' => new DeliveryProcessor($event->model),
            'completed' => new CompletedProcessor($event->model),
        };

        RunProcessor::run($processor);
    }
}
