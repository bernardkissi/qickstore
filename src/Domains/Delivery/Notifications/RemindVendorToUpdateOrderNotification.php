<?php

namespace Domain\Delivery\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Service\Notifications\Channels\SmsChannel;
use Service\Notifications\Types\Sms\SmsMessage;

class RemindVendorToUpdateOrderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public string $vendors)
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
        return [SmsChannel::class, 'mail'];
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
        return (new MailMessage())
            ->greeting('Hello!')
            ->line('One of your invoices has been paid!')
            ->line('Thank you for using our application!');
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return SmsMessage
     */
    public function toSms($notifiable)
    {
        return (new SmsMessage())
            ->from('Techshops')
            ->to($this->vendors)
            ->line('Hi Dear vendor,')
            ->line('We remanding you to update your orders where applicable');
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
