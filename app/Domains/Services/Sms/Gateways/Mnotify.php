<?php

namespace App\Domains\Services\Sms\Gateways;

use App\Domains\APIs\Mnotify\Sms\SendMnotifySms;
use App\Domains\Messages\Dtos\MessageDto;
use App\Domains\Services\Sms\SmsContract;

class Mnotify implements SmsContract
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
        return SendMnotifySms::build()
        ->withData(MessageDto::make(
            [
                'sender' => 'bernard',
                'recipient' => $data['recipients'],
                'message' => 'A buyer just bought a t-shirt from your shop',
                'schedule_date' => null,
                'is_schedule' => false
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
