<?php

namespace App\Domains\Delivery\Dispatchers;

use App\Core\Helpers\Dispatchers\Dispatcher;
use App\Domains\Delivery\Notifications\PromptVendorForDeliveryNotification;
use App\Domains\Orders\Model\Order;
use App\Domains\Services\Notifications\Channels\SmsChannel;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class CustomVendorShipping extends Dispatcher
{

     /**
     * Class constructor
     *
     * @param Order $order
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
            ->route(SmsChannel::class, '0543063709')
            ->notify(new PromptVendorForDeliveryNotification($this->order));
    }
}
