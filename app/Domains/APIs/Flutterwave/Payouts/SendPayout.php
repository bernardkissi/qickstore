<?php

declare(strict_types=1);

namespace App\Domains\APIs\Flutterwave\Payouts;

use App\Domains\APIs\Flutterwave\FlutterwaveRequest;

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

    /**
     * Data attached to the request
     *
     * @var array $data
     */
    protected array $data = [];
}
