<?php

namespace Domain\Disputes\Jobs;

use Domain\Disputes\Dispute;
use Domain\Disputes\DisputeAction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PersitDisputeActionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public Dispute|DisputeAction $dispute,
        public string $action,
        public string $message,
    ) {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->dispute->actions()->create([
            'action' => $this->action,
            'message' => $this->message,
        ]);
    }
}
