<?php

namespace Service\Webhooks\Jobs;

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
        dd('key');
        //update the payment model.

        // transistion order to paid.
    }
}
