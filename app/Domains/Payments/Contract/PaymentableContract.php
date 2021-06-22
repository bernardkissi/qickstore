<?php

namespace App\Domains\Payments\Contract;

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
    public function charge(Request $request): array;

    //TODO: accepts payment reference, or provider id
    public function track();
}
