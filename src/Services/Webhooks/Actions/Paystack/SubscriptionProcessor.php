<?php

declare(strict_types=1);

namespace Service\Webhooks\Actions\Paystack;

use Domain\Subscription\ProductSubscription;
use Domain\Subscription\States\Disabled;
use Service\Webhooks\Actions\ActionHandler;

class SubscriptionProcessor implements ActionHandler
{
    public static function handle(array $payload): void
    {
        match ($payload['event']) {
            'subscription.create' => dump('subscription created'),
            'subscription.disable' => dump('subscription disabled'),
            'subscription.enable' => dump('Invoice updated'),
            'subscription.not_renew' => static::notRenewing($payload),
            'subscription.expiring_cards' => dump('Invoice updated'),
        };
    }

    public static function notRenewing(array $payload)
    {
        // 'subscription.not_renew'
        // 1. not renew subscription on product subscription table on state not renewing
        // 2. send sms/email to customer about about not renvew subscribing to a product
        // 3. notify vendor about subscription not renewing
    }

    public static function disabled(array $payload)
    {
        $subscriptionCode = $payload['data']['subscription_code'];
        ProductSubscription::transitioning($subscriptionCode, Disabled::class);

        // 'subscription.disable',
        // 1. update subscription on product subscription table on state disabled
        // 2. send sms/email to customer about cancelling subscribing to a product
        // 3. notify vendor about subscription cancellation
    }


    public static function create(array $payload)
    {
        // 1. update subscription on product subscription table
        // 2. send sms/email to customer about successfully subscribing to a product
        // 3. notify vendor about subscription
    }

    public function enabled(array $payload)
    {
        // 'subscription.enable'
        // 1. enable subscription on product subscription table on state active
        // 2. send sms/email to customer about cancelling subscribing to a product
        // 3. notify vendor about subscription cancellation
    }

    public function expiringCards(array $payload)
    {
        // 'subscription.expiring_cards'
       // update state not renewing expiring_cards
       // send message to the customer with the link to update his expiring card
    }
}
