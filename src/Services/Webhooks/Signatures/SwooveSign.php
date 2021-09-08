<?php

declare(strict_types=1);

namespace Service\Webhooks\Signatures;

use App\Helpers\Signatures\Signature;
use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookConfig;

class SwooveSign extends Signature
{
    /**
     * Sign the swoove webhook route
     *
     * @return string
     */
    protected static function doSigning(Request $request, WebhookConfig $config): bool
    {
        return true;
    }
}
