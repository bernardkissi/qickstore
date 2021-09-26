<?php

namespace Service\Modifiers;

use Domain\Delivery\Delivery;
use Domain\Orders\OrderStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Service\Modifiers\Handlers\DeliveryStateProcessor;
use Service\Modifiers\Handlers\OrderStateProcessor;
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

        match (get_class($event->model)) {
            'Domain\Delivery\Delivery' => DeliveryStateProcessor::process($event->model, $state),
            'Domain\Orders\OrderStatus' => OrderStateProcessor::process($event->model, $state),
        };
    }
}
