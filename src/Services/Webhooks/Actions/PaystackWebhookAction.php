<?php

declare(strict_types=1);

namespace Service\Webhooks\Actions;

use Service\Webhooks\Actions\Paystack\PaymentProcessor;
use Service\Webhooks\WebhookAction;

class PaystackWebhookAction implements WebhookAction
{
    /**
     * Action to process swoove webhook calls
     *
     * @param array $data
     *
     *
     */
    public static function process(array $payload): void
    {
        match ($payload['event']) {
            'charge.success' => PaymentProcessor::handle($payload),
            'subscription.create','subscription.disable','subscription.enable' => dump('subscription_handler'),
            'transfer.failed','transfer.success','transfer.reversed' => dump('transfer_handler'),
            'invoice.create','invoice.payment_failed', 'invoice.update' => dump($payload),
        };
    }
}
