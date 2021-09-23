<?php

declare(strict_types=1);

namespace Domain\Payments\Actions;

use Domain\Payments\Payment;

class PaymentRetry
{
    public static function getPaymentLink(string $paymentReference): string
    {
        $link = Payment::firstWhere('tx_ref', $paymentReference)->pay_url;
        return $link;
    }
}
