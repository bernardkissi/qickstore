<?php

namespace App\Domains\Payments\Gateways;

use App\Domains\Payments\Contract\PaymentableContract;
use Illuminate\Http\Request;

class CashOnDelivery implements PaymentableContract
{
    /**
     * Charge customers on checkout
     *
     * @param Request $request
     * @param int $amount
     *
     * @return string
     */
    public function charge(Request $request): array
    {
        return ['hello'];
    }

    public function payout()
    {
    }

    public function track()
    {
    }
}
