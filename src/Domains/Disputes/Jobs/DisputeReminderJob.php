<?php

namespace Domain\Disputes\Jobs;

use Domain\Disputes\Dispute;
use Domain\Disputes\Notifications\RemindDisputeWithoutResponse;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use Service\Notifications\Channels\SmsChannel;

class DisputeReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $contacts = Dispute::noResponse()->get()->map(function ($dispute) {
            return $dispute->customer_mobile;
        })->toArray();

        $contacts = implode(',', $contacts);

        if ($contacts) {
            Notification::route(SmsChannel::class, $contacts)
                ->notify(new RemindDisputeWithoutResponse($contacts));
        }
    }
}
