<?php

namespace App\Domains\Delivery\Jobs;

use Spatie\WebhookClient\ProcessWebhookJob;

class DeliveryWebhookProcessJob extends ProcessWebhookJob
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        dd('am fired');
    }
}
