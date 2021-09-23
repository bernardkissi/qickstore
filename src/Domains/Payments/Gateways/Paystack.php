<?php

namespace Domain\Payments\Gateways;

use Carbon\Carbon;
use Domain\Payments\Contract\PaymentableContract;
use Domain\Payments\Dtos\PaymentDto;
use Domain\Payments\Traits\PaystackUpdater;
use Illuminate\Support\Str;
use Integration\Paystack\Payments\InitializePayment;
use Integration\Paystack\Payments\VerifyPayment;

class Paystack implements PaymentableContract
{
    use PaystackUpdater;

    /**
     * Charge the user through flutterwave gateway
     *
     * @param array $data
     *
     * @return array
     */
    public function charge(array $data): array
    {
        $ref = (string) Str::uuid();
        return InitializePayment::build()
            ->withData(
                PaymentDto::make([
                    'amount'    => $data['amount'],
                    'currency'  => 'GHS',
                    'reference' =>  $ref,
                    'email'     => $data['email'],
                    'callback_url' => route('home'),
                    'metadata' => [
                        'cancel_action' => "http://store.test/cancel?ref=$ref",
                        'order_id'  => $data['id'],
                        'has_subscription' => $data['has_subscription'],
                    ],
                ])->toArray()
            )
            ->send()
            ->json();
    }

    /**
     * Returns the payment request
     *
     * @param array $data
     *
     * @return array
     */
    public function verify(string $reference): array
    {
        return VerifyPayment::build()
            ->setPath("/transaction/verify/${reference}")
            ->send()
            ->json();
    }
}
