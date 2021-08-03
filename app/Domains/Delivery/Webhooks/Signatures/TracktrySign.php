<?php

declare(strict_types=1);

namespace App\Domains\Delivery\Webhooks\Signatures;

use App\Core\Helpers\Signatures\Signature;
use Illuminate\Http\Request;
use Spatie\WebhookClient\Exceptions\WebhookFailed;
use Spatie\WebhookClient\WebhookConfig;

class TracktrySign extends Signature
{
    /**
     * Sign the swoove webhook route
     *
     * @return string
     */
    protected static function doSigning(Request $request, WebhookConfig $config): bool
    {
        $signature = $request->header($config->signatureHeaderName);

        if (! $signature) {
            return false;
        }

        $signingSecret = $config->signingSecret;

        if (empty($signingSecret)) {
            throw WebhookFailed::signingSecretNotSet();
        }

        return hash_equals($signature, $signingSecret);
    }
}
