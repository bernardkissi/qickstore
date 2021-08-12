<?php

return [
     /*
        |--------------------------------------------------------------------------
        | Valid signatures
        |--------------------------------------------------------------------------
        |
        | The list of valid signatures for webhooks. You can add new valid signatures
        | here to sign webhooks from external services.
        |
        */

        'signatures' => [

            //signature_header_name   => 'Signing secret',
            'swoove-hash'   => '9fbd5b85b01835656ebc73c6a3d633b9',
            'tracktry-hash' => 'd81e66811509864b5ba541e5fe92e02b',
            'verify-hash'   => 'dbcb2e8542168cecd5399d4f7e85085e49861483',

        ],

        'configs' => [

            /*
            |--------------------------------------------------------------------------
            | Webhook configuration
            |--------------------------------------------------------------------------
            |
            | This is a list of configurables for webhooks supported by the application.
            | Feel free to add your own configurables here to handle new webhooks.
            | Consider reading https://github.com/spatie/laravel-webhook-client for
            | more information.
            |
            | Do not fill these fields with your own data ['signing_secret', 'signature_header_name'].
            | Add your signing secret to the 'valid_signatures' array instead.
            */

            [
                'name' => 'payments',
                'signing_secret' => '',
                'signature_header_name' => 'x-default',
                'signature_validator' =>  \App\Core\Helpers\Signatures\Signer::class,
                'webhook_profile' => \Spatie\WebhookClient\WebhookProfile\ProcessEverythingWebhookProfile::class,
                'webhook_response' => \Spatie\WebhookClient\WebhookResponse\DefaultRespondsTo::class,
                'webhook_model' =>   \App\Domains\Services\Webhooks\WebhookHandler::class,
                'process_webhook_job' => \App\Domains\Services\Webhooks\Jobs\PaymentWebhookJob::class,
            ],
            [
                'name' => 'deliveries',
                'signing_secret' => '',
                'signature_header_name' => 'x-default',
                'signature_validator' => \App\Core\Helpers\Signatures\Signer::class,
                'webhook_profile' => \Spatie\WebhookClient\WebhookProfile\ProcessEverythingWebhookProfile::class,
                'webhook_response' => \Spatie\WebhookClient\WebhookResponse\DefaultRespondsTo::class,
                'webhook_model' => \App\Domains\Services\Webhooks\WebhookHandler::class,
                'process_webhook_job' => \App\Domains\Services\Webhooks\Jobs\DeliveryWebhookJob::class,
            ],
        ],
];
