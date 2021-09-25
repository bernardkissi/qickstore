<?php

namespace Service\Modifiers;

use App\Helpers\Processor\RunProcessor;
use Domain\Orders\Processors\CancelledProcessor;
use Domain\Orders\Processors\CompletedProcessor;
use Domain\Orders\Processors\DeliveryProcessor;
use Domain\Orders\Processors\FailedProcessor;
use Domain\Orders\Processors\PaidProcessor;
use Domain\Orders\Processors\ProcessedProcessor;
use Domain\Orders\Processors\ShippedProcessor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\ModelStates\Events\StateChanged;

class StateChangeProcessor implements ShouldQueue
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
            'paid'      => new PaidProcessor($event->model),
            'processing' => new ProcessedProcessor($event->model),
            'failed'    => new FailedProcessor($event->model),
            'shipped'   => new ShippedProcessor($event->model),
            'delivered' => new DeliveryProcessor($event->model),
            'completed' => new CompletedProcessor($event->model),
            'cancelled' => new CancelledProcessor($event->model)
        };

        RunProcessor::run($processor);
    }
}
