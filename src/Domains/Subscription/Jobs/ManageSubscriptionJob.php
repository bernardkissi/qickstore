<?php

namespace Domain\Subscription\Jobs;

use Domain\Subscription\Actions\GenerateSubscriptionManageLink;
use Domain\Subscription\Notifications\ManageSubscriptionNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use Service\Notifications\Channels\SmsChannel;

class ManageSubscriptionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public string $number,
        public string $subscriptionCode,
    ) {
    }

    /**
     * Execute the job.
     * x
     * @return void
     */
    public function handle(): void
    {
        $link = GenerateSubscriptionManageLink::execute($this->subscriptionCode);

        if ($link) {
            Notification::route('mail', 'taylor@example.com')
            ->route(SmsChannel::class, $this->number)
            ->notify(new ManageSubscriptionNotification($this->number, $link));
        }
    }
}
