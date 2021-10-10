<?php

declare(strict_types=1);

namespace Domain\Refunds\Actions;

use Domain\Disputes\Dispute;
use Domain\Refunds\Jobs\RefundJob;
use Illuminate\Support\Facades\DB;

class ProcessRefund
{
    public static function refund(Dispute $dispute, array $data = []): void
    {
        DB::transaction(function () use ($dispute, $data) {
            $payload = [
                'transcation_reference' => $dispute->disputable_transcation_reference,
                'refund_at' => now(),
            ];
            dump($payload);
            if (!empty($data)) {
                $payload = collect($payload)->merge($data)->toArray();
            }

            $refund = $dispute->refund()->create($payload);

            RefundJob::dispatch($refund);
        });
    }
}
