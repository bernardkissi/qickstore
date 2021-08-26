<?php

namespace Domain\Delivery\Dispatchers;

use App\Core\Helpers\Dispatchers\Dispatcher;
use Domain\Delivery\Notifications\SendFileLinkToEmailNotification;
use Domain\Delivery\Traits\CanCreateDelivery;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;

class FileDelivery extends Dispatcher
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
        $url = URL::signedRoute('api:v1:download', ['order' => $this->order['order_id']]);

        Notification::route('mail', $this->order['customer_email'])
            ->notify(new SendFileLinkToEmailNotification($url));

        $payload = array_merge($this->order, ['download_link' => $url]);
        $this->createDelivery($payload);
    }
}
