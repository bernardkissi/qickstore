<?php

namespace App\Domains\Payouts\Contract;

interface PayableContract
{
    /**
     * Send payout request to our payment gateway
     *
     * @return array
     */
    public function pay(array $data): object;
}
