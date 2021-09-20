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
        var_dump('you hit me');

        //update the payment model.

        // transistion order to paid.
    }

    // /**
    // * Determines which action is to be used by the job
    // *
    // * @param string $signature_name
    // * @return string
    // */
    // protected static function useAction(string $signature): string
    // {
    //     return match ($signature) {
    //         'swoove-hash' => SwooveWebhookAction::class,
    //          default => 'No action found',
    //     };
    // }
}
