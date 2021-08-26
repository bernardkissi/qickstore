<?php

namespace Domain\Orders\Listeners;

use App\Core\Helpers\Processor\RunProcessor;
use Domain\Orders\Processors\CompletedProcessor;
use Domain\Orders\Processors\DeliveryProcessor;
use Domain\Orders\Processors\FailedProcessor;
use Domain\Orders\Processors\PaidProcessor;
use Domain\Orders\Processors\ShippedProcessor;
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
