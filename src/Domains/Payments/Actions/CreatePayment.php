<?php

declare(strict_types=1);

namespace Domain\Payments\Actions;

use Carbon\Carbon;
use Domain\Delivery\Jobs\DispatchOrderJob;
use Domain\Orders\Order;
use Domain\Payments\Jobs\PaymentCompletedJob;
use Domain\Payments\Payment;
use Domain\Subscription\Jobs\VerifySubscriptionJob;
use Illuminate\Support\Facades\Bus;

class CreatePayment
{
    public static function execute(array $data): void
    {
        $order = Order::firstWhere('provider_order_id', $data['data']['id']);
        $paymentRef = $data['data']['reference'];

        $payment =  Payment::create([
                        'tx_ref' => $paymentRef,
                        'status' => $data['data']['status'],
                        'provider' => 'paystack',
                        'channel' => $data['data']['channel'],
                        'amount' => $data['data']['amount'],
                        'customer_code' => $data['data']['customer']['customer_code'],
                        'authorization_code' => $data['data']['authorization']['authorization_code'],
                        'plan_code' => $data['data']['plan']['plan_code'],
                        'currency' => $data['data']['currency'],
                        'paid_at' => Carbon::parse($data['data']['paidAt']),
                        'ip' => $data['data']['ip_address'],
                        'provider_reference' => $data['data']['id'],
                        'order_id' => $order->id,
                        'has_subscription' => true,
                    ]);

        Bus::chain([
            new VerifySubscriptionJob($paymentRef, $payment, $order),
            new PaymentCompletedJob($order, $payment),
            new DispatchOrderJob($order),
        ])->dispatch();
    }
}
