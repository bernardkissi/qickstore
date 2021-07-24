<?php

namespace App\Domains\Orders\Notifications;

use App\Domains\Services\Notifications\Channels\SmsChannel;
use App\Domains\Services\Notifications\Types\Sms\SmsMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VendorOrderNotification extends Notification implements
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['SmsChannel::class'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return SmsMessage
     */
    public function toMail($notifiable)
    {
        return (new SmsMessage)
                    ->from('Techshops')
                    ->to('0552377591')
                    ->line('message here')
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
