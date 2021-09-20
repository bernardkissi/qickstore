<?php

namespace Domain\Delivery\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Service\Notifications\Channels\SmsChannel;
use Service\Notifications\Types\Sms\SmsMessage;

class ReportDeliveryErrorNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return [SmsChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return SmsMessage
     */
    public function toMail($notifiable)
    {
        return (new SmsMessage())
            ->from('Techshops')
            ->to('recipients')
            ->line('message here');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [

        ];
    }
}
