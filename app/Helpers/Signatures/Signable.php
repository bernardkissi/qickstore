<?php

declare(strict_types = 1);

namespace App\Helpers\Signatures;

use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookConfig;

interface Signable
{
    /**
     * Performs actual signing.
     *
     * @return string
     */
    public static function sign(Request $request, WebhookConfig $config): bool;
}
