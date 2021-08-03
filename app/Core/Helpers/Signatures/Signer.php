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
     * Holds the signing secret of the signature
     *
     * @var string
     */
    protected string $signing_secret;

    /**
     * References the signature name
     *
     * @var string
     */
    protected string $signing_header_name;


    /**
     * Checks for the validity of the signature used by the webhook.
     *
     * @param Request $request
     * @param WebhookConfig $config
     * @return bool
     */
    public function isValid(Request $request, WebhookConfig $config): bool
    {
        $this->generateSignatureInfo($request);

        $config->signatureHeaderName = $this->signing_header_name;
        $config->signingSecret = $this->signing_secret;

        var_dump($config);
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
            'verify-hash' => TracktrySign::sign($request, $config),
        };

        return $signature;
    }


    /**
     * Derives the signing secret and the header name of the signature
     *
     * @param Request $request
     * @return void
     */
    protected function generateSignatureInfo(Request $request): void
    {
        $signatures = config('webhook-client.signatures');
        $header = collect($signatures)->filter(function ($signature, $key) use ($request) {
            return $request->hasHeader($key);
        });

        $this->signing_header_name = $header->keys()[0];
        $this->signing_secret = $header[$this->signing_header_name];
    }
}
