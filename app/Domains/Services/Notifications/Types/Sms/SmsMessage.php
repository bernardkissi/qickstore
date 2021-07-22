<?php

namespace App\Domains\Services\Notifications\Types\Sms;

use App\Domains\Services\Notifications\Types\Sms\Facade\Sms;

class SmsMessage
{
    /**
     * @var string
     */
    protected string $to;

    /**
     * @var string
     */
    protected string $from;

    /**
     * @var string
     */
    protected string $message;

    /**
     * @var array
     */
    protected array $lines;


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
     * @param [type] $to
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
     * @param [type] $from
     * @return self
     */
    public function from($from): self
    {
        $this->from = $from;

        return $this;
    }

    // /**
    //  * Get the message
    //  *
    //  * @return void
    //  */
    // protected function message(): void
    // {
    //     $this->message = implode('', $this->lines);
    // }

    /**
     * Send the message
     *
     * @return mixed
     */
    public function send(): mixed
    {
        if (!$this->from || !$this->to || !count($this->lines)) {
            throw new \Exception('Sms message is missing some values');
        }

        $data = [

            'sender' => $this->from,
            'recipients' => $this->to,
            'message' => '$this->message',
            'schedule_at' => '',
            'sandbox' => false
        ];

        return Sms::send($data);
    }
}
