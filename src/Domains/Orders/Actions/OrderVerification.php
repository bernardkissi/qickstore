<?php

declare(strict_types=1);

namespace Domain\Orders\Actions;

use Domain\Orders\Order;
use Domain\Payments\Payment;

class OrderVerification
{
    public static function verify(string $paymentReference): Order
    {
        $payment = Payment::where('tx_ref', $paymentReference)->firstOrFail();
        $order = $payment->getOrder();
        // Get the order details
        // Greate a job that handles the verification and
        // updates the payment and moves the order to paid
        return $order->load(['products']);
    }
}
