<?php

declare(strict_types=1);

namespace Domain\Orders\Actions;

use Domain\Orders\Jobs\VerifyOrderJob;
use Domain\Orders\Order;
use Domain\Payments\Payment;

class OrderVerification
{
    public static function verify(string $paymentReference): Order
    {
        $payment = Payment::firstWhere('tx_ref', $paymentReference);
        $order = $payment->getOrder();

        VerifyOrderJob::dispatch(
            $paymentReference,
            $payment,
            $order
        );

        return $order->load(['products']);
    }
}
