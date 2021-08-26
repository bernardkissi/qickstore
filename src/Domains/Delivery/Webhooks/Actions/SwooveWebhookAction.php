<?php

declare(strict_types=1);

namespace Domain\Delivery\Webhooks\Actions;

use App\Core\Helpers\Transitions\MapState;
use Domain\Delivery\Delivery;
use Domain\Services\Webhooks\WebhookAction;

class SwooveWebhookAction implements WebhookAction
{
    /**
     * Action to process swoove webhook calls
     *
     * @param array $data
     * @return void
     */
    public static function process(array $payload): void
    {
        dd('yes am here right now');
        $delivery = Delivery::where('delivery_id', $payload['id'])->first();

        $state = MapState::map($payload['status']);

        if (!$delivery->state->canTransitionTo($state)) {
            return;
        }

        $delivery->state->transitionTo($state);
    }
}
