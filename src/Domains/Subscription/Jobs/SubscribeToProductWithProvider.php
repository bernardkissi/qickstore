<?php

namespace Domain\Subscription\Jobs;

use Carbon\Carbon;
use Domain\Subscription\ProductSubscription;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Integration\Paystack\Subscriptions\CreateSubscription;

class SubscribeToProductWithProvider implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    //TODO: make provider flexible
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public ProductSubscription $subscription
    ) {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subscription = CreateSubscription::build()->withData([
            'plan' => $this->subscription->plan_code,
            'customer' => $this->subscription->customer_code,
            'authorization' => $this->subscription->auth_code,
            'start_date' => $this->subscription->start_date
        ])->send()->json();

        if (!array_key_exists('data', $subscription)) {
            return;
        }

        $this->subscription->update([
                 'email_token' => $subscription['data']['email_token'],
                 'cron_expression' => $subscription['data']['cron_expression'],
                 'next_billing_date' => Carbon::parse($subscription['data']['next_payment_date']),
                 'invoice_limit' => $subscription['data']['invoice_limit'],
                 'subscription_id' => $subscription['data']['id']
        ]);
    }
}
