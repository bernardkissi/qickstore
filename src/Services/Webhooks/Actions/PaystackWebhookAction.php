<?php

declare(strict_types=1);

namespace Service\Webhooks\Actions;

use Service\Webhooks\Actions\Paystack\InvoiceProcessor;
use Service\Webhooks\Actions\Paystack\PaymentProcessor;
use Service\Webhooks\Actions\Paystack\SubscriptionProcessor;
use Service\Webhooks\Actions\Paystack\TransferProcessor;
use Service\Webhooks\WebhookAction;

class PaystackWebhookAction implements WebhookAction
{
    /**
     * Action to process swoove webhook calls
     *
     * @param array $data
     */
    public static function process(array $payload): void
    {
        match ($payload['event']) {
            'charge.success' => PaymentProcessor::handle($payload),
            'subscription.create','subscription.disable','subscription.enable' => SubscriptionProcessor::handle($payload),
            'transfer.failed','transfer.success','transfer.reversed' => TransferProcessor::handle($payload),
            'invoice.create','invoice.payment_failed', 'invoice.update' => InvoiceProcessor::handle($payload),
        };
    }
}
