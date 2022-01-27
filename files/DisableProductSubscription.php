<?php

declare(strict_types=1);

namespace Domain\Subscription\Actions;

use Domain\Subscription\ProductSubscription;
use Domain\Subscription\States\Disabled;
use Integration\Paystack\Subscriptions\DisableSubscription;

class DisableProductSubscription
{
    public static function execute(string $subscription_code, string $email_token): void
    {
        $data = DisableSubscription::build()
            ->withData([
                'code' => $subscription_code,
                'token' => $email_token
            ])
            ->send()
            ->json();

        dump($data);

        if ($data['status']) {
            ProductSubscription::transitioning($subscription_code, Disabled::class);
        }
    }
}
