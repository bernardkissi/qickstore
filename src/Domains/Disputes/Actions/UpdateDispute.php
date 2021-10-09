<?php

namespace Domain\Refunds\Actions;

use Domain\Disputes\Dispute;
use Illuminate\Support\Facades\DB;

class UpdateDispute
{
    /**
     * Merchant Response to Dispute
     *
     * @param Dispute $dispute
     * @param array $data
     * @return void
     */
    public static function reply(Dispute $dispute, array $data): void
    {
        DB::transaction(function () use ($dispute, $data) {
            $dispute->update([
                'merchant_response' => $data['merchant_response'],
                'has_attachment' => $data['has_attachment'] ?? false,
            ]);

            if ($data['has_attachment']) {
                $dispute->uploadAttachment($data['attachment']);
            }
        });
    }
}
