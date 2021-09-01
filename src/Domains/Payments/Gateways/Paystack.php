<?php

namespace Domain\Payments\Gateways;

use Domain\Payments\Contract\PaymentableContract;
use Domain\Payments\Dtos\PaymentDto;
use Integration\Paystack\Payments\InitializePayment;
use Integration\Paystack\Payments\PaystackPaymentPayload;

class Paystack implements PaymentableContract
{
    /**
     * Charge the user through flutterwave gateway
     *
     * @param array $data
     *
     * @return array
     */
    public function charge(array $data): array
    {
        $payload = PaymentDto::make($data)->toArray();
        return InitializePayment::build()
            ->withData(PaystackPaymentPayload::payload($payload))
            ->send()
            ->json();
    }

    /**
     * Returns the payment request
     *
     * @param array $data
     * @return array
     */
    public function callback(): void
    {
    }
}
