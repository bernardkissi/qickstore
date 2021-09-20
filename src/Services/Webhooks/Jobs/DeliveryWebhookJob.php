<?php

namespace Service\Webhooks\Jobs;

use Domain\Delivery\Webhooks\Actions\SwooveWebhookAction;
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
        $action = self::useAction($this->webhookCall->signature);
        $action::process($this->webhookCall->payload);
    }

    /**
     * Determines which action is to be used by the job
     *
     * @param string $signature_name
     *
     * @return string
     */
    protected static function useAction(string $signature): string
    {
        return match ($signature) {
            'swoove-hash' => SwooveWebhookAction::class,
             default => 'No action found',
        };
    }
}
