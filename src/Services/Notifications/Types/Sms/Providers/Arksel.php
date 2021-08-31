<?php

namespace Service\Notifications\Types\Sms\Providers;

use Domain\Messages\Dtos\MessageDto;
use Integration\Arksel\Sms\SendArkselSms;
use Service\Notifications\Types\Sms\SmsContract;

class Arksel implements SmsContract
{
    /**
     * Send text message
     *
     * @param string $message
     * @param array $numbers
     * @return void
     */
    public function send(array $data): array
    {
        return SendArkselSms::build()
        ->withData(MessageDto::make(
            [
                'sender' => 'Techshops',
                'recipients' => $data['recipients'],
                'message' => $data['message'],
                'schedule_at' => '',
                'sandbox' => false
            ]
        )->toArray())
        ->send()->json();
    }

    /**
     * Get message status
     *
     * @param string $messageId
     * @return array
     */
    public function getStatus(string $messageId): array
    {
        return ['demo'];
    }

    /**
     * Webhook call route
     *
     * @param array $data
     * @return void
     */
    public function callback(array $data): void
    {
    }
}
