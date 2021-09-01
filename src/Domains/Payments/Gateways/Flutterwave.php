<?php

namespace Domain\Payments\Gateways;

use Domain\Payments\Contract\PaymentableContract;
use Integration\Flutterwave\Payment\MakePayment;
use Integration\Flutterwave\Payment\PaymentRequest;

class Flutterwave implements PaymentableContract
{
    use PaymentRequest;
    /**
     * Charge the user through flutterwave gateway
     *
     * @param array $data
     *
     * @return array
     */
    public function charge(array $data): array
    {
        return MakePayment::build()
            ->withData($this->data($data))
            ->send()
            ->json();
    }

    public function callback(): void
    {
    }
}
