<?php

namespace App\Domains\Payments\Jobs;

use Spatie\WebhookClient\ProcessWebhookJob;

class ProcessPaymentJob extends ProcessWebhookJob
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
