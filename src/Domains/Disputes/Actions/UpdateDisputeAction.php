<?php

namespace Domain\Refunds\Actions;

use Domain\Disputes\DisputeAction;
use Illuminate\Support\Facades\DB;

class UpdateDisputeAction
{
    public static function update(DisputeAction $action, array $data): void
    {
        DB::transaction(function () use ($action, $data) {
            $action->update([
                'action' => $data['action'],
                'message' => $data['message'] ?? false,
            ]);
        });
    }
}
