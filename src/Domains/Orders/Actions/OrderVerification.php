<?php

declare(strict_types=1);

namespace Domain\Orders\Actions;

class OrderVerification
{
    public static function verify(string $paymentReference): void
    {
        // Get the order details
        // Greate a job that handles the verification and
        // updates the payment and moves the order to paid
        // returns a response
    }
}
