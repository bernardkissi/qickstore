<?php

declare(strict_types=1);

namespace Domain\Refunds\Actions;

use Domain\Refunds\Dispute;
use Domain\Refunds\DisputeAction;
use Domain\Refunds\Jobs\UploadAttachmentJob;

class AddDisputeAction
{
    public function add(Dispute $dispute, array $data): DisputeAction
    {
        $attachment = $data['attachment'] ?? null;

        $action = $dispute->actions()->create([

            'action' => $data['action'] ?? null,
            'message' => $data['message'],
        ]);

        if ($attachment) {
            UploadAttachmentJob::dispatch($action, $attachment);
        }

        return $action;
    }
}
