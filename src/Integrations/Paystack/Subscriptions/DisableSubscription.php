<?php

declare(strict_types=1);

namespace Integration\Paystack\Subscriptions;

use Integration\Paystack\PaystackRequest;

class DisableSubscription extends PaystackRequest
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
    protected string $path = '/subscription/disable';
}
