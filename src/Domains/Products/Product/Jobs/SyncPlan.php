<?php

namespace Domain\Products\Product\Jobs;

use Domain\Products\Product\ProductPlan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Integration\Paystack\Plans\CreatePlan;

class SyncPlan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public ProductPlan $plan
    ) {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $plan = CreatePlan::build()->withData([
            'name' => $this->plan->plan_name,
            'amount' => $this->plan->price,
            'interval' => $this->plan->interval,
            'send_sms' => $this->plan->send_sms,
            'description' => $this->plan->plan_decription,
            'currency' => $this->plan->currency,
            'invoice_limit' => $this->plan->duration,
        ])->send()->json();

        $this->plan->update([
            'plan_code' => $plan['data']['plan_code'],
        ]);
    }
}
