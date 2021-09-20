<?php

namespace Domain\Orders\Listeners;

use Domain\Payments\Payment;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreatePayment implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     *
     * @return void
     */
    public function handle($event)
    {
        Payment::create([
            'tx_ref' => $event->payment['data']['reference'],
            'access_code' => $event->payment['data']['access_code'],
            'pay_url' => $event->payment['data']['authorization_url'],
            'status' => 'pending',
            'provider' => 'paystack',
            'channel' => 'mobile money',
            'amount' => $event->order->subtotal,
            'order_id' => $event->order->id,
        ]);
    }
}
