<?php

declare(strict_types=1);

namespace Domain\Subscription\Actions;

class UpdateProductSubscription
{
    public static function execute(array $data): void
    {
        var_dump('updating product subscription');
        // $subscription->update([
        //     'sku_id' => $data['sku_id'],
        //     'order_id' => $data['order_id'],
        //     'channel' => $data['channel'],
        //     'start_date' => $data['start_date'] ?? null,
        //     'end_date' => $data['end_date'] ?? null,
        //     'next_billing_date' => $data['next_billing_date'] ?? null,
        //     'cron_expression' => $data['cron_expression'] ?? null,
        // ]);
    }
}
