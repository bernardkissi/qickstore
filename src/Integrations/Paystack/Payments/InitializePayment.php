<?php

namespace Integration\Paystack\Payments;

use Integration\Paystack\PaystackRequest;

class InitializePayment extends PaystackRequest
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
    protected string $path = '/transaction/initialize';
}
