<?php

declare(strict_types=1);

namespace Domain\Payments\Traits;

use Carbon\Carbon;
use Domain\Payments\Payment;

trait PaystackUpdater
{
    public function updatePayment(Payment $payment, array $data): void
    {
        $payment->update([
            'status' => $data['status'],
            'history' => $data['log']['history'],
            'provider_reference' => $data['id'],
            'currency' => $data['currency'],
            'customer_code' => $data['customer']['customer_code'],
            'authorization_code' => $data['authorization']['authorization_code'],
            'ip_address' => $data['ip_address'],
            'channel' => $data['channel'],
            'plan' => $data['plan'],
            'paid_at' => Carbon::parse($data['paid_at']),
        ]);
    }
}
