<?php

declare(strict_types=1);

namespace Domain\Subscription\Actions;

use Domain\Subscription\ProductSubscription;
use Domain\Subscription\States\Active;
use Integration\Paystack\Subscriptions\EnableSubscription;

class EnableProductSubscription
{
    public static function execute(string $subscription_code, string $email_token): void
    {
        $data = EnableSubscription::build()
            ->withData([
                'code' => $subscription_code,
                'token' => $email_token
            ])
            ->send()
            ->json();
        dump($data);
        if ($data['status']) {
            ProductSubscription::transitioning($subscription_code, Active::class);
        }
    }
}
