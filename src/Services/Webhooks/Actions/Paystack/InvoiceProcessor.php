<?php

declare(strict_types=1);

namespace Service\Webhooks\Actions\Paystack;

use Domain\Subscription\Notifications\CreateInvoiceNotification;
use Domain\Subscription\Notifications\PaymentFailedNotification;
use Domain\Subscription\ProductSubscription;
use Domain\Subscription\States\PaymentFailed;
use Illuminate\Support\Facades\Notification;
use Integration\Paystack\Subscriptions\GenerateSubscriptionLink;
use Service\Notifications\Channels\SmsChannel;
use Service\Webhooks\Actions\ActionHandler;

class InvoiceProcessor implements ActionHandler
{
    public static function handle(array $payload): void
    {
        match ($payload['event']) {
            'invoice.create' => static::createInvoice($payload),
            'invoice.payment_failed' => static::paymentFailed($payload),
            'invoice.update' => dump('Invoice updated'),
        };
    }

    /**
     * Send customer invoice for subscription payment
     *
     * @param array $payload
     * @return void
     */
    protected static function createInvoice(array $payload): void
    {
        Notification::route('mail', static::customerDetails($payload)['email'])
            ->route(SmsChannel::class, static::customerDetails($payload)['phone'])
            ->notify(new CreateInvoiceNotification($payload));
    }

    /**
     * Notify customer about subcription payment failure
     *
     * @param array $payload
     * @return void
     */
    protected static function paymentFailed(array $payload)
    {
        $subscriptionCode = $payload['data']['subscription']['subscription_code'];

        $data = GenerateSubscriptionLink::build()
            ->setPath("/subscription/${subscriptionCode}/manage/link/")
            ->send()
            ->json();

        Notification::route('mail', static::customerDetails($payload)['email'])
                ->route(SmsChannel::class, static::customerDetails($payload)['phone'])
                ->notify(new PaymentFailedNotification($payload, $data['data']['link']));

        ProductSubscription::transitioning($subscriptionCode, PaymentFailed::class);
    }

    /**
     * Get customer details from payload
     *
     * @param array $payload
     * @return array
     */
    protected static function customerDetails(array $payload): array
    {
        return [
            'email' => $payload['data']['customer']['email'],
            'phone' => $payload['data']['customer']['phone'],
        ];
    }
}
