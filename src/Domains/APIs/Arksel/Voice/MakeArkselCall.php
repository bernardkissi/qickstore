<?php

declare(strict_types=1);

namespace Domain\APIs\Arksel\Voice;

use Domain\APIs\Arksel\ArkselRequest;

class MakeArkselCall extends ArkselRequest
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
    protected string $path = 'sms/voice/send';

    /**
     * Data attached to the request
     *
     * @var array $data
     */
    protected array $data = [];


    public function attachMedia()
    {
        $audio  = fopen((public_path('storage/demo.wav')), 'r');

        $request = $this->getRequest();
        $request->attach('voice_file', $audio, 'demo.wav');

        return $this;
    }
}
