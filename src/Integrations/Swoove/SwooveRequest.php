<?php

declare(strict_types=1);

namespace Integration\Swoove;

use JustSteveKing\Transporter\Request;

class SwooveRequest extends Request
{
    /**
     * Base url for the endpoint for the request
     *
     * @var string $baseUrl
     */
    protected string $baseUrl = 'https://test.swooveapi.com';

    /**
     * Add query params to request
     *
     * @var array $query
     */
    protected array $query = ['app_key' => 'ff7b66fe-1070-46e0-a63c-f36de8762385'];
}
