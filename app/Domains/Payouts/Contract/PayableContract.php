<?php

namespace App\Domains\Payouts\Contract;

use Illuminate\Http\Request;

interface PayableContract
{
    /**
     * Send payout request to our payment gateway
     *
     * @return array
     */
    public function pay(array $data): object;
}
