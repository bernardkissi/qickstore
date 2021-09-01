<?php

namespace Integration\Paystack\Payments;

use Domain\Payments\Dtos\PaymentDto;
use Illuminate\Support\Str;

class PaystackPaymentPayload
{
    /**
     * Prepare user payment information
     *
     * @param array $data
     *
     * @return PaymentDto
     */
    public static function payload(array $data): array
    {
        return [
                'amount' => $data['amount'],
                'currency' => 'GHS',
                'reference' => (string) Str::uuid(),
                'email' => $data['customer']['email'],
                'callback_url' => route('home'),
                'metadata' => [
                    'order_id' => $data["order"]['id'],
                    'has_subscription' => $data["order"]['has_subscritpion'],
                ],
            ];
    }
}
