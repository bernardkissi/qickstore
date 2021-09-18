<?php

declare(strict_types=1);

namespace Service\Webhooks\Actions;

use App\Helpers\Transitions\MapState;
use Domain\Delivery\Delivery;
use Illuminate\Support\Facades\Log;
use Service\Webhooks\WebhookAction;

class PaystackWebhookAction implements WebhookAction
{
    /**
     * Action to process swoove webhook calls
     *
     * @param array $data
     * @return void
     */
    public static function process(array $payload): void
    {
    }
}
