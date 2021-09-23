<?php

namespace Domain\Orders\Jobs;

use Domain\Orders\Order;
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
    public function __construct(
        public string $reference,
        public Payment $payment,
        public Order $order
    ) {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $data = PaymentGateway::verify($this->reference)['data'];
        PaymentGateway::updatePayment($this->payment, $data);

        if ($data) {
            $this->order->orderable->cart()->detach();
        }

        // call payment event handle
    }
}
