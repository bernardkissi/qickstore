<?php

declare(strict_types=1);

namespace Service\Notifications\Types\Voice;

interface VoiceContract
{
    /**
     * Make a call to a phone number
     *
     * @return array
     */
    public function call(array $data): array;
}
