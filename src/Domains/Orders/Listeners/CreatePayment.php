<?php

namespace Domain\Orders\Listeners;

use Domain\Payments\Payment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;

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
            'tx_ref' => $event->payment['data']['reference'] ?? Str::uuid(),
            'access_code' => $event->payment['data']['access_code'] ?? null,
            'pay_url' => $event->payment['data']['authorization_url'] ?? null,
            'status' => $event->payment === null ? 'success' : 'pending',
            'provider' => $event->payment === null ? 'qickspace' : 'paystack',
            'channel' => $event->payment === null ? 'cashless' : 'mobile money',
            'amount' => $event->order->subtotal,
            'order_id' => $event->order->id,
        ]);
    }
}
