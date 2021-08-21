<?php

declare(strict_types=1);

namespace App\Core\Helpers\Signatures;

use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookConfig;

class Signature implements Signable
{
    /**
     * Perfoms signing of the webhook request.
     *
     * @return string
     */
    public static function sign(Request $request, WebhookConfig $config): bool
    {
        return static::doSigning($request, $config);
    }

    /**
     * Peforms actual validation of the webhook request.
     *
     * @return string
     */
    protected static function doSigning(Request $request, WebhookConfig $config): ?bool
    {
        return false;
    }
}
