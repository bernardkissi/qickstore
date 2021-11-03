<?php

namespace Domain\Delivery\Handlers;

use App\Helpers\Dispatchers\Dispatcher;
use Domain\Delivery\Notifications\SendFileLinkToEmailNotification;
use Domain\Delivery\Traits\CanCreateDelivery;
use Domain\Orders\Order;
use Illuminate\Support\Facades\DB;
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
        DB::transaction(function () {
            $url = URL::signedRoute('api:v1:download', ['order' => $this->order['order_id']]);

            Notification::route('mail', $this->order['customer_email'])
                ->route(VoiceChannel::class, '0543063709')
                ->notify(new SendFileLinkToEmailNotification($url));

            $payload = array_merge($this->order, ['download_link' => $url]);
            $delivery = $this->createDelivery($payload);
            $delivery->transitionDelivery('delivered');

            $order = Order::find($this->order['order_id']);
            $order->transitionState('delivered');
        });
    }
}
