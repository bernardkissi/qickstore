<?php

namespace Domain\Payments\Contract;

use Illuminate\Http\Request;

interface PaymentableContract
{
    /**
     * Charge customers on checkout
     *
     * @param Request $request
     * @param int $amount
     *
     * @return array
     */
    public function charge(array $data): array;

    /**
     * Returns a payload for making the request
     *
     * @param array $data
     * @return array
     */
    public function callback(): void;
}
