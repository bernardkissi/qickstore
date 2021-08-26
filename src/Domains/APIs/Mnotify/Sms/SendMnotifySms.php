<?php

declare(strict_types=1);

namespace Domain\APIs\Mnotify\Sms;

use Domain\APIs\Mnotify\MnotifyRequest;

class SendMnotifySms extends MnotifyRequest
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
    protected string $path = '/sms/quick';
}
