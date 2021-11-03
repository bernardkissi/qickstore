<?php

declare(strict_types=1);

namespace Integration\Paystack\Refunds;

use Integration\Paystack\PaystackRequest;

class RefundPayment extends PaystackRequest
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
    protected string $path = '/refund';
}
