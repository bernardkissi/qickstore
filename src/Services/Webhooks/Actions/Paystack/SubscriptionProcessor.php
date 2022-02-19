<?php

declare(strict_types=1);

namespace Service\Webhooks\Actions\Paystack;

use Carbon\Carbon;
use Domain\Subscription\Jobs\ManageSubscriptionJob;
use Domain\Subscription\Notifications\CreateSubscriptionNotification;
use Domain\Subscription\Notifications\DisabledSubscriptionNotification;
use Domain\Subscription\ProductSubscription;
use Domain\Subscription\States\CardExpiry;
use Domain\Subscription\States\Disabled;
use Domain\Subscription\States\NotRenewing;
use Illuminate\Support\Facades\Notification;
use Service\Webhooks\Actions\ActionHandler;

class SubscriptionProcessor implements ActionHandler
{
    public static function handle(array $payload): void
    {
        match ($payload['event']) {
            'subscription.create' => dump('subscription created'),
            'subscription.disable' => static::disabled($payload),
            'subscription.enable' => dump('Invoice updated'),
            'subscription.not_renew' => static::notRenewing($payload),
            'subscription.expiring_cards' => dump('Invoice updated'),
        };
    }

    /**
     * Subscription not-renewing hook
     *
     * @param array $payload
     * @return void
     */
    public static function notRenewing(array $payload)
    {
        $subscriptionCode = static::customerDetails($payload)['subscription_code'];
        $customerNumber = static::customerDetails($payload)['phone'];

        $cancelled_at = Carbon::parse($payload['data']['cancelledAt']);
        ProductSubscription::transitioning($subscriptionCode, NotRenewing::class, $cancelled_at);
        Notification::route('mail', static::customerDetails($payload)['email'])
                ->route(SmsChannel::class, static::customerDetails($payload)['phone'])
                ->notify(new DisabledSubscriptionNotification($payload));
    }

    /**
     * Subscription disabled hook
     *
     * @param array $payload
     * @return void
     */
    public static function disabled(array $payload)
    {
        $subscriptionCode = static::customerDetails($payload)['subscription_code'];
        $customerNumber = static::customerDetails($payload)['phone'];

        ProductSubscription::transitioning($subscriptionCode, Disabled::class);
        Notification::route('mail', static::customerDetails($payload)['email'])
                ->route(SmsChannel::class, static::customerDetails($payload)['phone'])
                ->notify(new DisabledSubscriptionNotification($payload));
    }

    /**
     * Subscription created hook
     *
     * @param array $payload
     * @return array
     */
    public static function create(array $payload)
    {
        Notification::route('mail', static::customerDetails($payload)['email'])
                ->route(SmsChannel::class, static::customerDetails($payload)['phone'])
                ->notify(new CreateSubscriptionNotification($payload));
    }


    public function expiringCards(array $payload)
    {
        $subscriptionCode = static::customerDetails($payload)['subscription_code'];
        $customerNumber = static::customerDetails($payload)['phone'];

        ProductSubscription::transitioning($subscriptionCode, CardExpiry::class);
        ManageSubscriptionJob::dispatch($customerNumber, $subscriptionCode);
    }


    /**
    * Get customer details from payload
    *
    * @param array $payload
    *
    * @return array
    */
    protected static function customerDetails(array $payload): array
    {
        return [
            'email' => $payload['data']['customer']['email'],
            'phone' => $payload['data']['customer']['phone'] ?? '0552377591',
            'subscription_code' => $payload['data']['subscription_code'],
        ];
    }
}
