<?php

declare(strict_types=1);

namespace Domain\Disputes\Actions;

use Domain\Orders\Order;
use Illuminate\Support\Facades\DB;

class CreateDispute
{

    /**
     * Create disputes for the given order.
     *
     * @param Order $order
     * @param array $data
     * @return void
     */
    public static function dispute(Order $order, array $data): void
    {
        DB::transaction(function () use ($order, $data) {
            $dispute = $order->dispute()->create([
                'disputable_reference_id' => $order->uuid,
                'disputable_transcation_reference' => $order->payment->tx_ref,
                'subject' => $data['subject'],
                'customer_dispute' => $data['customer_dispute'],
                'customer_mobile'  => $data['customer_mobile'],
                'customer_email'   => $data['customer_email'] ?? null,
                'has_attachment'   => $data['has_attachment'] ?? false,
            ]);

            if ($data['has_attachment']) {
                $dispute->uploadAttachment($data['attachment']);
            }

            $order->transition($order->status, 'disputed');
        });
    }
}
