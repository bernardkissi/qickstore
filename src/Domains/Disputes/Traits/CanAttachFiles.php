<?php

declare(strict_types=1);

namespace Domain\Disputes\Traits;

use Illuminate\Http\UploadedFile;

trait CanAttachFiles
{
    public function uploadAttachment(UploadedFile $file, string $attachment = 'attachment'): void
    {
        $extension = $file->getClientOriginalExtension();

        $this->addMediaFromRequest($attachment)
                ->usingFileName("$this->id.$extension")
                ->toMediaCollection('dispute_attachments');
    }
}
