<?php

declare(strict_types=1);

namespace Domains\Subscription\Actions;

use Domain\Subscription\ProductSubscription;

class UpdateProductSubscription
{
    public static function execute(array $data): void
    {
        $subscription = ProductSubscription::firstWhere(
            'subscription_code',
            $data['data']['subscription']['subscription_code']
        );

        $subscription->update([
            'channel' => $data['data']['authorization']['card_type'],
            'start_date' => $data['period_date'] ?? null,
            'end_date' => $data['period_date'] ?? null,
            'next_billing_date' => $data['data']['subscription']['next_payment_date'] ?? null,
            'cron_expression' => $data['cron_expression'] ?? null,
            'state' => $data['data']['subscription']['status']
        ]);
    }
}
