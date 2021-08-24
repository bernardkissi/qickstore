<?php

namespace App\Domains\Delivery\Dispatchers;

use App\Core\Helpers\Dispatchers\Dispatcher;
use App\Domains\Delivery\Notifications\SendFileLinkToEmailNotification;
use App\Domains\Orders\Model\Order;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

class FileDelivery extends Dispatcher
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
     * Send downloadable file link to the customer's email.
     *
     * @return void
     */
    public function dispatch(): void
    {
        $url = URL::signedRoute('download', ['order' => $this->order['order_id']]);

        Notification::route('mail', $this->order['customer_email'])
            ->notify(new SendFileLinkToEmailNotification($url));
    }
}
