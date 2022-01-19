<?php

declare(strict_types=1);

namespace Service\Webhooks\Actions\Paystack;

use Domain\Subscription\Notifications\CreateInvoiceNotification;
use Illuminate\Support\Facades\Notification;
use Service\Notifications\Channels\SmsChannel;
use Service\Webhooks\Actions\ActionHandler;

class InvoiceProcessor implements ActionHandler
{
    public static function handle(array $payload): void
    {
        match ($payload['event']) {
            'invoice.create' => static::createInvoice($payload),
            'invoice.payment_failed' => static::paymentFailed($payload),
            'invoice.update' => static::updateInvoice($payload),
        };
    }

    protected static function createInvoice(array $payload)
    {
        dump($payload); // Notification::route(SmsChannel::class, $payload['data']['customer']['phone'])
        //         ->notify(new CreateInvoiceNotification($payload));
    }

    protected static function paymentFailed(array $payload)
    {
        dump($payload);
        //status
        //descritpion
        //open invoice
        //card_type
    }

    protected static function updateInvoice(array $data)
    {
        //subscription_code
        //card_type
        //next_payment_due
        //status
    }
}

//invoice.create
// Remind the customer subscription is almost due for renewal

//invoice.payment_failed
//notify customer subscription payment failed
//update the statement
//option to retry

//invoice.update
//notify customer subscription has been successfully renewed
