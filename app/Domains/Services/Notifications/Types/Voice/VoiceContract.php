<?php

declare(strict_types=1);

namespace App\Domains\Services\Notifications\Types\Voice;

interface VoiceContract
{
    /**
     * Make a call to a phone number
     *
     * @return array
     */
    public function call(array $data) : array;
}