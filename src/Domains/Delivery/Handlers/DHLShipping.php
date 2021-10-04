<?php

namespace Domain\Delivery\Handlers;

use App\Helpers\Dispatchers\Dispatcher;
use Domain\Delivery\Notifications\SendFileLinkToEmailNotification;
use Domain\Delivery\Traits\CanCreateDelivery;
use Domain\Orders\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

class DHLShipping extends Dispatcher
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
     * Send downloadable file link to the customer's email.
     *
     * @return void
     */
    public function dispatch(): void
    {
        echo "we are shipping with DHL";
    }
}
