<?php

declare(strict_types=1);

namespace App\Domains\APIs\Swoove\Delivery;

use App\Domains\APIs\Swoove\SwooveRequest;

class CreateDelivery extends SwooveRequest
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
    protected string $path = 'estimates/create-estimate';

    /**
     * Data attached to the request
     *
     * @var array $data
     */
    protected array $data = [];
}
