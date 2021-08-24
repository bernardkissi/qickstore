<?php

namespace App\Domains\Delivery\Notifications;

use App\Domains\Orders\Model\Order;
use App\Domains\Services\Notifications\Channels\SmsChannel;
use App\Domains\Services\Notifications\Types\Sms\SmsMessage;
use App\Domains\Services\Notifications\Types\Voice\VoiceMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PromptVendorForDeliveryNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public Order|array $order)
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
        return ['SmsChannel::class', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return SmsMessage
     */
    public function toSms($notifiable)
    {
        return (new SmsMessage)
                ->from('Techshops')
                ->to('0552377591')
                ->line('Please an order has been successfully made')
                ->line('proceed to make delivery');
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                ->greeting('Dear Mr.Bernard')
                ->line('We will like to inform you an order has been succesfully made on your store.')
                ->line('Please proceed to make delivery.')
                ->action('View Order', 'http://localhost:8000')
                ->line('Thank you for using qickshops!');
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
