<?php

declare(strict_types=1);

namespace Domain\Subscription\Actions;

use App\ProductSubscription;

class CreateProductSubsctription
{
    public function execute(array $data): void
    {
        var_dump('creating product subscription');
        // ProductSubscription::create([
        //     'sku_id' => $data['sku_id'],
        //     'order_id' => $data['order_id'],
        //     'plan_id' => $data['plan_id'],
        //     'auth_code' => $data['authorization']['authorization_code'],
        //     'email_token' => $data['email_token'] ?? null,
        //     'channel' => $data['channel'],
        //     'plan' => $data['plan'],
        //     'customer_code' => $data['customer_code'],
        //     'customer_email' => $data['customer_email'],
        //     'start_date' => $data['start_date'] ?? null,
        //     'end_date' => $data['end_date'] ?? null,
        //     'next_billing_date' => $data['next_billing_date'] ?? null,
        //     'cron_expression' => $data['cron_expression'] ?? null,
        // ]);
    }
}
