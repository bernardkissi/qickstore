<?php

declare(strict_types=1);

namespace Service\Webhooks\Actions\Paystack;

use Carbon\Carbon;
use Domain\Payments\Payment;

class UpdatePayment
{
    public static function handle(array $payload): void
    {
        $payment = Payment::firstWhere('tx_ref', $payload['data']['reference']);

        if ($payment) {
            $payment->update([
                'status' => $payload['status'],
                'history' => $payload['log']['history'],
                'provider_reference' => $payload['id'],
                'currency' => $payload['currency'],
                'customer_code' => $payload['customer']['customer_code'],
                'authorization_code' => $payload['authorization']['authorization_code'],
                'ip_address' => $payload['ip_address'],
                'channel' => $payload['channel'],
                'plan' => $payload['plan'],
                'paid_at' => Carbon::parse($payload['paid_at']),
                'has_subscription' => $payload['metadata']['has_subscription'],
                'subaccount' => $payload['subaccount'],
                'card_type' => $payload['authorization']['card_type'],
            ]);
        }
    }
}
