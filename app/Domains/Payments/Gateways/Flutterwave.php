<?php

namespace App\Domains\Payments\Gateways;

use App\Domains\APIs\Flutterwave\Payment\MakePayment;
use App\Domains\APIs\Flutterwave\Payment\PaymentRequest;
use App\Domains\Payments\Contract\PaymentableContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
