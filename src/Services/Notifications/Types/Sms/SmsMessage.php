<?php

namespace Service\Notifications\Types\Sms;

use Service\Notifications\Types\Sms\Facade\Sms;

class SmsMessage
{
    /**
     * @var string
     */
    protected string $to = '';

    /**
     * @var string
     */
    protected string $from = '';

    /**
     * @var array
     */
    protected array $lines = [];

    /**
     * SmsMessage constructor.
     *
     * @param array $lines
     */
    public function __construct($lines = [])
    {
        $this->lines = $lines;
    }

    /**
     * Write a message line
     *
     * @param string $line
     *
     * @return self
     */
    public function line($line = ''): self
    {
        $this->lines[] = $line;

        return $this;
    }

    /**
     *  Who recieves the sms
     *
     * @param string $to
     *
     * @return self
     */
    public function to($to): self
    {
        $this->to = $to;

        return $this;
    }

    /**
     * Sender of the notification
     *
     * @param string $from
     *
     * @return self
     */
    public function from($from): self
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Send the message
     *
     * @return mixed
     */
    public function send(): mixed
    {
        if (! $this->from || ! $this->to || ! count($this->lines)) {
            throw new \Exception('Sms message is missing some values');
        }

        $data = [
            'sender' => $this->from,
            'recipients' => explode(',', $this->to),
            'message' => implode('', $this->lines),
            'schedule_at' => '',
            'sandbox' => true,
        ];

        return Sms::send($data);
    }
}
