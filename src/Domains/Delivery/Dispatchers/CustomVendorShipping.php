<?php

namespace Domain\Delivery\Dispatchers;

use App\Helpers\Dispatchers\Dispatcher;
use Domain\Delivery\Notifications\PromptVendorForDeliveryNotification;
use Domain\Delivery\Traits\CanCreateDelivery;
use Domain\Services\Notifications\Channels\SmsChannel;
use Illuminate\Support\Facades\Notification;

class CustomVendorShipping extends Dispatcher
{
    use CanCreateDelivery;

    /**
    * Class constructor
    *
    * @param array $order
    * @param string $fileUrl
    */
    public function __construct(
        public array $order
    ) {
    }

    /**
     * Returns an instance of the File Delivery
     *
     * @return Dispatcher
     */
    public function getInstance(): Dispatcher
    {
        return new self($this->order);
    }

    /**
     * Notify vendor of the about the delivery.
     *
     * @return void
     */
    public function dispatch(): void
    {
        Notification::route('mail', $this->order['customer_email'])
            ->route(VoiceChannel::class, '0543063709')
            ->notify(new PromptVendorForDeliveryNotification($this->order));

        $this->createDelivery($this->order);
    }
}
