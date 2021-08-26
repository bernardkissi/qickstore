<?php

namespace Domain\Payouts\Contract;

interface PayableContract
{
    /**
     * Send payout request to our payment gateway
     *
     * @return array
     */
    public function pay(array $data): void;
}
