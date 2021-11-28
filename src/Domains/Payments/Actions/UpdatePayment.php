<?php

declare(strict_types=1);

namespace Domain\Payments\Actions;

use Carbon\Carbon;
use Domain\Payments\Payment;

class UpdatePayment
{
    public static function execute(array $payload): void
    {
        $payment = Payment::firstWhere('tx_ref', $payload['data']['reference']);

        if ($payment) {
            $payment->update([
                'status' => $payload['data']['status'],
                'history' => $payload['data']['log']['history'] ?? null,
                'provider_reference' => $payload['data']['id'],
                'currency' => $payload['data']['currency'],
                'customer_code' => $payload['data']['customer']['customer_code'],
                'authorization_code' => $payload['data']['authorization']['authorization_code'],
                'ip_address' => $payload['data']['ip_address'],
                'channel' => $payload['data']['channel'],
                'plan' => $payload['data']['plan'],
                'paid_at' => Carbon::parse($payload['data']['paid_at']),
                'has_subscription' => $payload['data']['metadata']['has_subscription'],
                'subaccount' => $payload['data']['subaccount'],
                'card_type' => $payload['data']['authorization']['card_type'],
            ]);
        }
    }
}
