<?php

namespace Domain\Payments\Webhooks\Signatures;

use App\Helpers\Signatures\Signature;
use Illuminate\Http\Request;
use Spatie\WebhookClient\Exceptions\WebhookFailed;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;
use Spatie\WebhookClient\WebhookConfig;

class FlutterwaveSign extends Signature
{
    /**
     * Check if local signature and incoming are valid
     *
     * @param Request $request
     * @param WebhookConfig $config
     * @return boolean
     */
    public static function doSigning(Request $request, WebhookConfig $config): bool
    {
        dd('hey');
        $signature = $request->header($config->signatureHeaderName = '1234');

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
