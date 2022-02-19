<?php

namespace Domain\Subscription\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Service\Notifications\Channels\SmsChannel;
use Service\Notifications\Types\Sms\SmsMessage;

class ManageSubscriptionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public string $number, public string $link)
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
        return ['mail', SmsChannel::class];
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
            ->to('0552377591')
            ->line(
                'Your payment card is expiring soon,
                please click the link below to manage your subscription'
            )->line($this->link);
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->greeting('Hello!')
            ->line('Your payment is expiring is soon')
            ->line('Please change your payment details')
            ->line('We will not be able to send you any more emails until you update your payment details.')
            ->action('Manage subscription', $this->link);
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
