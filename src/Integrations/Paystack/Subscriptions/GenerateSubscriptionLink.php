<?php

declare(strict_types=1);

namespace Integration\Paystack\Subscriptions;

use Integration\Paystack\PaystackRequest;

class GenerateSubscriptionLink extends PaystackRequest
{
    /**
     * Base url for the endpoint for the request
     *
     * @var string $baseUrl
     */
    protected string $method = 'GET';
}
