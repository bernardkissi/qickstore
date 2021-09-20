<?php

namespace Service\Webhooks\Signatures;

use App\Helpers\Signatures\Signature;
use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookConfig;

class PaystackSign extends Signature
{
    /**
     * Check if local signature and incoming are valid
     *
     * @param Request $request
     * @param WebhookConfig $config
     *
     * @return bool
     */
    public static function doSigning(Request $request, WebhookConfig $config): bool
    {
        $signature = $request->header($config->signatureHeaderName);

        if (! $signature) {
            return false;
        }

        $sec_key = 'sk_test_78be11cde858e5e90c7a784865ebafecf5d10a1d';

        $computedSignature = hash_hmac('sha512', $request->getContent(), $sec_key);

        return hash_equals($signature, $computedSignature);
    }
}
