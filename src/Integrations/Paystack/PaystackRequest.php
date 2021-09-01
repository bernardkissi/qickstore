<?php

declare(strict_types=1);

namespace Integration\Paystack;

use Illuminate\Http\Client\PendingRequest;
use JustSteveKing\Transporter\Request;

class PaystackRequest extends Request
{
    /**
     * Base url for the endpoint for the request
     *
     * @var string $baseUrl
     */
    protected string $baseUrl = 'https://api.paystack.co';

    /**
     * Attach api-token to request
     *
     * @param PendingRequest $request
     * @return void
     */
    protected function withRequest(PendingRequest $request): void
    {
        $request->withToken(env('PAYSTACK_SEC_KEY'));
    }
}
