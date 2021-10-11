<?php

declare(strict_types=1);

namespace Service\Webhooks\Actions;

use Service\Webhooks\Actions\Paystack\UpdatePayment;
use Service\Webhooks\WebhookAction;

class PaystackWebhookAction implements WebhookAction
{
    /**
     * Action to process swoove webhook calls
     *
     * @param array $data
     *
     * @return void
     */
    public static function process(array $payload): void
    {
        dump($payload['event']);

        match ($payload['event']) {
            'charge.success' => dump('payment_handler'),//UpdatePayment::handle($payload),
            'subscription.create','subscription.disable', 'subscription.enable' => dump('subscription_handler'),
            'transfer.failed','transfer.success','transfer.reversed' => dump('transfer_handler'),
        };
    }
}
