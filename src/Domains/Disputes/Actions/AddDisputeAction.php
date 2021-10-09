<?php

declare(strict_types=1);

namespace Domain\Disputes\Actions;

use Domain\Disputes\Dispute;
use Illuminate\Support\Facades\DB;

class AddDisputeAction
{
    public static function add(Dispute $dispute, array $data): ?Dispute
    {
        $action = null;
        DB::transaction(function () use ($dispute, $data) {
            $action = $dispute->actions()->create([
                'action' => $data['action'] ?? null,
                'message' => $data['message'],
                'has_attachment' => $data['has_attachment'] ?? false,
            ]);

            if ($data['has_attachment']) {
                $action->uploadAttachment($data['attachment']);
            }
        });

        return $action;
    }
}
