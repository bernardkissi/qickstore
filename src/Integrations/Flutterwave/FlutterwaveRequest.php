<?php

declare(strict_types=1);

namespace Integration\Flutterwave;

use Illuminate\Http\Client\PendingRequest;
use JustSteveKing\Transporter\Request;

class FlutterwaveRequest extends Request
{

     /**
     * Base url for the endpoint for the request
     *
     * @var string $baseUrl
     */
    protected string $baseUrl = 'https://api.flutterwave.com/v3';


    /**
     * Attach api-token to request
     *
     * @param PendingRequest $request
     * @return void
     */
    protected function withRequest(PendingRequest $request): void
    {
        $request->withToken(env('FLUTTERWAVE_SEC_KEY'));
    }
}
