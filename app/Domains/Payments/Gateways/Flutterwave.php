<?php

namespace App\Domains\Payments\Gateways;

use App\Domains\APIs\Flutterwave\Payment\MakePayment;
use App\Domains\APIs\Flutterwave\Payment\PaymentRequest;
use App\Domains\Payments\Contract\PaymentableContract;
use Illuminate\Http\Request;

class Flutterwave implements PaymentableContract
{
    use PaymentRequest;
    /**
     * Charge the user through flutterwave gateway
     *
     * @param Request $request
     *
     * @return array
     */
    public function charge(Request $request): array
    {
        return  MakePayment::build()
        ->withData(static::data($request))
        ->send()
        ->json();
    }

    public function track()
    {
    }
}
