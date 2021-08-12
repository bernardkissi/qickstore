<?php

namespace App\Domains\Services\Webhooks\Jobs;

use Spatie\WebhookClient\ProcessWebhookJob;

class PaymentWebhookJob extends ProcessWebhookJob
{

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //update the payment model.

        // transistion order to paid.
    }
}
