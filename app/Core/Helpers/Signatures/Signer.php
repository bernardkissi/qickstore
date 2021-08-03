<?php

declare(strict_types=1);

namespace App\Core\Helpers\Signatures;

use App\Domains\Delivery\Webhooks\Signatures\SwooveSign;
use App\Domains\Delivery\Webhooks\Signatures\TracktrySign;
use Illuminate\Http\Request;
use Spatie\WebhookClient\SignatureValidator\SignatureValidator;
use Spatie\WebhookClient\WebhookConfig;

class Signer implements SignatureValidator
{
    /**
     * Checks for the validity of the signature used by the webhook.
     *
     * @param Request $request
     * @param WebhookConfig $config
     * @return bool
     */
    public function isValid(Request $request, WebhookConfig $config): bool
    {
        return $this->resolveSignature($request, $config);
    }

    /**
     * Resolves the signature used by the webhook.
     *
     * @param Request $request
     * @param WebhookConfig $config
     * @return bool
     */
    public function resolveSignature(Request $request, WebhookConfig $config): bool
    {
        $signature = match ($config->signatureHeaderName) {
            'tracktry-hash' => TracktrySign::sign($request, $config),
            'swoove-hash' => SwooveSign::sign($request, $config),
        };

        return $signature;
    }
}
