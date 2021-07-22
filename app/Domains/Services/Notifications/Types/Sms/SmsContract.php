<?php

namespace  App\Domains\Services\Notifications\Types\Sms;

interface SmsContract
{
    /**
     * Send Text Message
     *
     * @param array $data
     * @return void
     */
    public function send(array $data): array;

    /**
     * Retrieve the delivery status of a text message
     *
     * @param string $messageId
     * @return array
     */
    public function getStatus(string $messageId): array;

    /**
     * Intercepts webhook callback
     *
     * @param array $data
     * @return void
     */
    public function callback(array $data): void;
}
