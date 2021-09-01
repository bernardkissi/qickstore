<?php

namespace Domain\Payments\Gateways;

use Domain\Payments\Contract\PaymentableContract;
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
    public function charge(array $payload): array
    {
        return ['hello'];
    }

    public function callback(): void
    {
    }
}
