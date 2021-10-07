<?php

namespace Domain\Refunds\Jobs;

use Domain\Refunds\Dispute;
use Domain\Refunds\DisputeAction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UploadAttachmentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public Dispute|DisputeAction $model,
        public string $attachment
    ) {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $collection = $this->model instanceof Dispute ? 'disputes' : 'dispute_actions';

        $attachment = $this->model
            ->addMediaFromRequest($this->attachment)
            ->toMediaCollection($collection);

        $this->model->update(['has_attachment' => true]);
    }
}
