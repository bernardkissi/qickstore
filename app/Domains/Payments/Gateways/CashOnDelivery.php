<?php

namespace App\Domains\Payments\Gateways;

use App\Domains\Payments\Contract\PaymentableContract;
use App\Domains\User\User;
use App\Domains\User\Visitor;

class CashOnDelivery implements PaymentableContract
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
        return "You will pay $amount on delivery. ";
    }

    public function payout()
    {
    }

    public function track()
    {
    }
}
