<?php

declare(strict_types=1);

namespace Integration\Arksel;

use Illuminate\Http\Client\PendingRequest;
use JustSteveKing\Transporter\Request;

class ArkselRequest extends Request
{
    /**
     * Base url for the endpoint for the request
     *
     * @var string $baseUrl
     */
    protected string $baseUrl = 'https://sms.arkesel.com/api/v2';


    /**
     * Attach api-token to request
     *
     * @param PendingRequest $request
     * @return void
     */
    protected function withRequest(PendingRequest $request): void
    {
        $request->withHeaders(['api-key' => 'dkpzYXFyY3JKYkpuckNPaGNuaG8']);
    }
}
