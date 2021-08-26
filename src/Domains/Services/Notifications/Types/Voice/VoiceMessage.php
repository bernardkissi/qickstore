<?php

namespace Domain\Services\Notifications\Types\Voice;

use Domain\Services\Notifications\Types\Voice\Facade\Voice;

class VoiceMessage
{
    /**
     * @var string
     */
    protected $to;

    /**
     * @var string
     */
    protected string $from;

    /**
     * @var string
     */
    protected string $audio;

    /**
     * SmsMessage constructor.
     *
     * @param array $lines
     */
    public function __construct($to = [])
    {
        $this->to = $to;
    }

    /**
     * Write a message line
     *
     * @param string $line
     * @return self
     */
    public function audio($audio = ''): self
    {
        $this->audio = $audio;

        return $this;
    }

    /**
     *  Who recieves the sms
     *
     * @param [type] $to
     * @return self
     */
    public function to($to): self
    {
        $this->to[] = $to;

        return $this;
    }

    /**
     * Send the message
     *
     * @return array
     */
    public function send(): array
    {
        if (!$this->to || !$this->audio) {
            throw new \Exception('Voice message is missing some values');
        }

        $data = [

            'voice_file' => $this->audio,
            'recipients' => $this->to,
        ];

        return Voice::call($data);
    }
}
