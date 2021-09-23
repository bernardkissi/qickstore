<?php

namespace Domain\Orders\Jobs;

use Domain\Payments\Facade\Payment as PaymentGateway;
use Domain\Payments\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class VerifyOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public string $reference)
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $data = PaymentGateway::verify($this->reference)['data'];
        $payment = Payment::firstWhere('tx_ref', $this->reference);
        PaymentGateway::updatePayment($payment, $data);

        if ($data) {
            $payment->order->orderable->cart()->detach();
        }
        // call payment event handle
    }
}
