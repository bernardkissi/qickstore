<?php

declare(strict_types=1);

namespace Domain\Refunds\Actions;

use Domain\Orders\Order;
use Domain\Refunds\Jobs\UploadAttachmentJob;
use Illuminate\Support\Facades\DB;

class CreateDispute
{
    public static function dispute(Order $order, array $data, bool $hasAttachment): void
    {
        DB::transaction(function () use ($order, $data, $hasAttachment) {
            $dispute = $order->dispute()->create([
                'disputable_reference_id' => $order->uuid,
                'disputable_transcation_reference' => $order->payment->tx_ref,
                'subject' => $data['subject'],
                'customer_dispute' => $data['customer_dispute'],
                'customer_mobile' => $data['customer_mobile'],
                'customer_email' => $data['customer_email'] ?? null,
            ]);

            if ($hasAttachment) {
                UploadAttachmentJob::dispatch($dispute, $data['attachment']);
            }

            $order->transition($order->status, 'disputed');
        });
    }
}
