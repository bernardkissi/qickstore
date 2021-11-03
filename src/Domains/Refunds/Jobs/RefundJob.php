<?php

namespace Domain\Refunds\Jobs;

use Carbon\Carbon;
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
                'transaction' => $this->refund->transcation_reference,
                'amount' => $this->refund->refund_amount,
                'merchant_reason' => $this->refund->refund_reason,
            ])
            ->send()
            ->json();

        if ($refund['status']) {
            $this->refund->update([
                'status' => $refund['data']['status'],
                'refund_amount' => $refund['data']['amount'],
                'refund_reason' => $refund['data']['merchant_note'],
                'expected_at' => Carbon::parse($refund['data']['expected_at'])->toDateTimeString(),
                'refund_at' => Carbon::parse($refund['data']['createdAt'])->toDateTimeString(),
                'refund_id' => $refund['data']['id'],
            ]);
        }
    }
}
