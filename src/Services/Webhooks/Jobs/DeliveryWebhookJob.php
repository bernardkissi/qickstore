<?php

namespace Service\Webhooks\Jobs;

use Domain\Delivery\Webhooks\Actions\SwooveWebhookAction;
use Service\Webhooks\Actions\PaystackWebhookAction;
use Spatie\WebhookClient\ProcessWebhookJob;

class DeliveryWebhookJob extends ProcessWebhookJob
{
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        match ($this->webhookCall->signature) {
            'x-paystack-signature' => PaystackWebhookAction::process($this->webhookCall->payload),
              default => 'No action found',
        };
    }
}
