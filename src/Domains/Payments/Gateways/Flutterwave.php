<?php

namespace Domain\Payments\Gateways;

use Domain\APIs\Flutterwave\Payment\MakePayment;
use Domain\APIs\Flutterwave\Payment\PaymentRequest;
use Domain\Payments\Contract\PaymentableContract;

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

    public function track()
    {
    }
}
