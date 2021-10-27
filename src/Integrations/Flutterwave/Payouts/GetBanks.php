<?php

declare(strict_types=1);

namespace Integration\Flutterwave\Payouts;

use Integration\Flutterwave\FlutterwaveRequest;

class GetBanks extends FlutterwaveRequest
{
    /**
     * Base url for the endpoint for the request
     *
     * @var string $baseUrl
     */
    protected string $method = 'GET';

    /**
    * Add query params to request
    *
    * @var string $query
    */
    protected string $path = "/banks";
}
