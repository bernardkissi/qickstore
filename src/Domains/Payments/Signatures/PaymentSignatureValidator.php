<?php

namespace Domain\Payments\Signatures;

use Illuminate\Http\Request;
use Spatie\WebhookClient\Exceptions\WebhookFailed;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;
use Spatie\WebhookClient\WebhookConfig;

class PaymentSignatureValidator implements SignatureValidator
{
    /**
     * Check if local signature and incoming are valid
     *
     * @param Request $request
     * @param WebhookConfig $config
     * @return boolean
     */
    public function isValid(Request $request, WebhookConfig $config): bool
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
