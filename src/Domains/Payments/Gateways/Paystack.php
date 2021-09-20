<?php

namespace Domain\Payments\Gateways;

use Domain\Payments\Contract\PaymentableContract;
use Domain\Payments\Dtos\PaymentDto;
use Illuminate\Support\Str;
use Integration\Paystack\Payments\InitializePayment;
use Integration\Paystack\Payments\VerifyPayment;

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
            ->withData(static::preparePayload($payload))
            ->send()
            ->json();
    }

    /**
     * Returns the payment request
     *
     * @param array $data
     * @return array
     */
    public function callback(string $reference): array
    {
        return VerifyPayment::build()
        ->withQuery(['reference' => $reference])
        ->send()
        ->json();
    }


    protected static function preparePayload(array $data)
    {
        return PaymentDto::make([
            'amount' => $data['amount'],
            'currency' => 'GHS',
            'reference' => (string) Str::uuid(),
            'email' => $data['email'],
            'callback_url' => route('home'),
            'metadata' => [
                'order_id' => $data['id'],
                'has_subscription' => $data['has_subscription'],
            ],
        ])->toArray();
    }
}
