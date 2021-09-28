<?php

declare(strict_types=1);

namespace Domain\Orders\Actions;

use Domain\Delivery\Jobs\DispatchOrderJob;
use Domain\Orders\Jobs\VerifyOrderJob;
use Domain\Orders\Order;
use Domain\Payments\Jobs\PaymentCompletedJob;
use Domain\Payments\Payment;
use Illuminate\Support\Facades\Bus;

class OrderVerification
{
    public static function verify(string $paymentReference): Order
    {
        $payment = Payment::firstWhere('tx_ref', $paymentReference);
        $order = $payment->getOrder();


        //if payment is already marked as paid
        // skip verificaition and print order

        Bus::chain([
            new VerifyOrderJob($paymentReference, $payment, $order),
            new PaymentCompletedJob($order, $payment),
            new DispatchOrderJob($order)
        ])->dispatch();

        return $order->load(['products']);
    }
}
