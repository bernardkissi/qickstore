<?php

namespace Domain\Payments\Jobs;

use Domain\Orders\Order;
use Domain\Orders\States\Paid;
use Domain\Payments\Payment;
use Domain\Subscription\ProductSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PaymentCompletedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public Order $order,
        public Payment $payment
    ) {
    }

    /**
     * Execute the job.
     * todo: add payment transition
     *
     * @return void
     */
    public function handle(): void
    {
        $orderState = $this->order->status;

        if ($orderState->state->canTransitionTo(Paid::class)) {
            $orderState->state->transitionTo(Paid::class);
            $orderState->updateTimeline('paid');

            $subscriptionId =  $this->payment->subscription_id;

            is_null($subscriptionId) ? null : ProductSubscription::firstWhere('id', $subscriptionId)
                ->increment('payment_count') ;
        }
    }
}
