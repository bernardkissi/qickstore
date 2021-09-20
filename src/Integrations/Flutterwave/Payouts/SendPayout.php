<?php

declare(strict_types=1);

namespace Integration\Flutterwave\Payouts;

use Integration\Flutterwave\FlutterwaveRequest;

class SendPayout extends FlutterwaveRequest
{
    /**
     * Base url for the endpoint for the request
     *
     * @var string $baseUrl
     */
    protected string $method = 'POST';

    /**
     * Add query params to request
     *
     * @var string $query
     */
    protected string $path = '/transfers';
}
