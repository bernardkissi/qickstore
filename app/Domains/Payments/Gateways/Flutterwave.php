<?php

namespace App\Domains\Payments\Gateways;

use App\Domains\Payments\Contract\PaymentableContract;
use App\Domains\User\User;
use App\Domains\User\Visitor;

class Flutterwave implements PaymentableContract
{
    /**
     * Charge customers on checkout
     *
     * @param User|Visitor $customer
     * @param int $amount
     * @return string
     */
    public function charge(User|Visitor $customer, int $amount): string
    {
        return "you are being charged. $amount";
    }

    public function payout()
    {
    }

    public function track()
    {
    }
}
