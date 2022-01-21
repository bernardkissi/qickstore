<?php

namespace Service\Modifiers;

use Illuminate\Contracts\Queue\ShouldQueue;
use Service\Modifiers\Handlers\DeliveryStateProcessor;
use Service\Modifiers\Handlers\DisputeStateProcessor;
use Service\Modifiers\Handlers\OrderStateProcessor;
use Service\Modifiers\Handlers\SubscriptionStateProcessor;
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
            'Domain\Disputes\Dispute' => DisputeStateProcessor::process($event->model, $state),
            'Domain\Subscription\ProductSubscription' => SubscriptionStateProcessor::process($event->model, $state)
        };
    }
}
