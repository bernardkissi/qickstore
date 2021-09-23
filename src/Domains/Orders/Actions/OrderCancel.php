<?php

declare(strict_types = 1);

namespace Domain\Orders\Actions;

use Domain\Orders\States\Cancelled;
use Domain\Payments\Payment;

class OrderCancel
{
    public static function cancel(string $paymentReference): void
    {
        $payment = Payment::firstWhere('tx_ref', $paymentReference);

        dispatch(function () use ($payment) {
            $orderState = $payment->order->status;

            //$payment->state->transitionTo('cancelled');

            if ($orderState->state->canTransitionTo(Cancelled::class)) {
                $orderState->state->transitionTo(Cancelled::class);
                $orderState->updateHistory('cancelled');
            }
        })->afterResponse();
    }
}
