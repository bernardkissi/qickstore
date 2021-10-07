<?php

namespace Domain\Orders\Jobs;

use Domain\Refunds\Refund;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Integration\Paystack\Refunds\RefundPayment;

class RefundJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public Refund $refund,
    ) {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $refund = RefundPayment::build()
            ->withData([
                'transcation' => $this->refund->transaction_reference,
                'amount' => $this->refund->refund_amount,
                'merchant_reason' => $this->refund->refund_reason,
            ])
            ->send()
            ->json();

        $this->refund->update([
            'status' => $refund['data']['status'],
            'refund_reference' => $refund['data']['dispute'],
            'refund_amount' => $refund['data']['amount'],
        ]);
    }
}
