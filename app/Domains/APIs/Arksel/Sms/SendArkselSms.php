<?php

declare(strict_types=1);

namespace App\Domains\APIs\Arksel\Sms;

use App\Domains\APIs\Arksel\ArkselRequest;

class SendArkselSms extends ArkselRequest
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
    protected string $path = '/sms/send';

    /**
     * Data attached to the request
     *
     * @var array $data
     */
    protected array $data = [];
}
