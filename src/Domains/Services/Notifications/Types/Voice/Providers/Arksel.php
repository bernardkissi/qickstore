<?php

declare(strict_types=1);

namespace Domain\Services\Notifications\Types\Voice\Providers;

use Domain\APIs\Arksel\Voice\MakeArkselCall;
use Domain\Services\Notifications\Types\Voice\VoiceContract;

class Arksel implements VoiceContract
{
    /**
     * Make call to a number.
     *
     * @param array $data
     * @return array
     */
    public function call(array $data): array
    {
        $payload = $this->formData($data);

        $res = MakeArkselCall::build()
        ->attachMedia()
        ->withData($payload)
        ->send();

        return $res->json();
    }


    /**
     * Format form data into supported Mulitpart format
     *
     * @param array $data
     * @return array
     */
    protected function formData(array $data): array
    {
        $output = [];

        foreach ($data as $key => $value) {
            if (!is_array($value)) {
                $output[] = ['name' => $key, 'contents' => $value];
                continue;
            }

            foreach ($value as $subKey => $subValue) {
                $subName = $key . '[' .$subKey . ']' . (is_array($subValue) ? '[' . key($subValue) . ']' : '') . '';
                $output[] = ['name' => $subName, 'contents' => (is_array($subValue) ? reset($subValue) : $subValue)];
            }
        }

        return $output;
    }
}
