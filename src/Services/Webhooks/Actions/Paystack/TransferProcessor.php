<?php

declare(strict_types=1);

namespace Service\Webhooks\Actions\Paystack;

use Service\Webhooks\Actions\ActionHandler;

class TransferProcessor implements ActionHandler
{
    public static function handle(array $payload): void
    {
    }
}

//transfer.success
// Notify customer that transfer has been made and will recieve the amount due soon
//transfer.failed
// Notify customer that transfer has failed due to x reason
//transfer.reversed
// Notify customer that transfer has been reversed due to x reason
