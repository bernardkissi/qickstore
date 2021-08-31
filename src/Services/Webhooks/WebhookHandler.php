<?php

declare(strict_types=1);

namespace Service\Webhooks;

use Illuminate\Http\Request;
use Spatie\WebhookClient\Models\WebhookCall;
use Spatie\WebhookClient\WebhookConfig;

class WebhookHandler extends WebhookCall
{
    /**
    *  Custom model table
    *
    * @var string
    */
    protected $table = 'webhook_calls';


    /**
     * Saves webhooks payload into our datastore
     *
     * @param WebhookConfig $config
     * @param Request $request
     * @return WebhookCall
     */
    public static function storeWebhook(WebhookConfig $config, Request $request): WebhookCall
    {
        return self::create([
            'name' => $config->name,
            'signature' => $config->signatureHeaderName,
            'payload' => $request->input(),
        ]);
    }
}
