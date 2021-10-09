<?php

declare(strict_types=1);

namespace Domain\Refunds\Actions;

use Domain\Disputes\Dispute;
use Illuminate\Support\Facades\DB;

class ProcessRefund
{
    public static function refund(Dispute $orderDispute, array $data): void
    {
        DB::transaction(function () use ($orderDispute, $data) {
            $orderDispute->refund()->create([
                'transcation_reference' => $orderDispute->transaction_reference,
                'refund_reason' => $data['refund_reason'] ?? null,
                'refund_amount' => $data['refund_amount'] ?? null,
                'refund_at' => now(),
            ]);
        });
    }
}
