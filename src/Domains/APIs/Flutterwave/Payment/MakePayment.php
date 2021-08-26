<?php

namespace Domain\APIs\Flutterwave\Payment;

use Domain\APIs\Flutterwave\FlutterwaveRequest;

class MakePayment extends FlutterwaveRequest
{

    /**
     * Base url for the endpoint for the request
     *
     * @var string $baseUrl
     */
    protected string $method = 'POST';

    /**
     * Request path to the endpoint
     *
     * @var string $query
     */
    protected string $path = '/payments';
}
