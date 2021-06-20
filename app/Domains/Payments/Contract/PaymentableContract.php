<?php

namespace App\Domains\Payments\Contract;

use App\Domains\User\User;
use App\Domains\User\Visitor;

interface PaymentableContract
{
    /**
     * Charge customers on checkout
     *
     * @param User|Visitor $customer
     * @param int $amount
     * @return string
     */
    public function charge(User|Visitor $customer, int $amount): string;

    // TODO :Add Store, amount to requested to payout
    public function payout();

    //TODO: accepts payment reference, or provider id
    public function track();
}
