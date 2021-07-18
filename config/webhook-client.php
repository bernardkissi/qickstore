<?php

return [
    'configs' => [

        /*
        |--------------------------------------------------------------------------
        | Payment webhooks
        |--------------------------------------------------------------------------
        |
        | This configuration handles all payment webhooks in the entire application.
        | Classes handling various actions can be swap with custom classes. see
        | https://github.com/spatie/laravel-webhook-client for guide.
        |
        */

        [
            'name' => 'default',
            'signing_secret' => env('FLUTTERWAVE_SIGNATURE'),
            'signature_header_name' => 'verif-hash',
            'signature_validator' => \App\Domains\Payments\Services\PaymentSignatureValidator::class,
            'webhook_profile' => \Spatie\WebhookClient\WebhookProfile\ProcessEverythingWebhookProfile::class,
            'webhook_response' => \Spatie\WebhookClient\WebhookResponse\DefaultRespondsTo::class,
            'webhook_model' => \Spatie\WebhookClient\Models\WebhookCall::class,
            'process_webhook_job' => \App\Domains\Payments\Jobs\ProcessPaymentJob::class,
        ],
        // \Spatie\WebhookClient\SignatureValidator\DefaultSignatureValidator::class
    ],
];
