<?php

namespace Domain\Delivery\Handlers;

use App\Helpers\Dispatchers\Dispatcher;
use Domain\Delivery\Notifications\PromptVendorForDeliveryNotification;
use Domain\Delivery\Traits\CanCreateDelivery;
use Illuminate\Support\Facades\Notification;

class VendorShipping extends Dispatcher
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
