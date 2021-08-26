<?php

declare(strict_types=1);

namespace Domain\APIs\Mnotify;

use JustSteveKing\Transporter\Request;

class MnotifyRequest extends Request
{
    /**
     * Base url for the endpoint for the request
     *
     * @var string $baseUrl
     */
    protected string $baseUrl = 'https://api.mnotify.com/api';

    /**
    * Add query params to request
    *
    * @var array $query
    */
    protected array $query = ['key' => 'VQ392Lg1LgmDZQiZxvoIEGSs3rsB2UwXLA7OmoP8EcLD3'];
}
