<?php

namespace Domain\Delivery\Jobs;

use Domain\Delivery\Dispatchers\Dispatcher;
use Domain\Orders\Order;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DispatchOrderJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;

    /**
     * The maximum number of unhandled exceptions to allow before failing.
     *
     * @var int
     */
    public $maxExceptions = 1;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public Order $order
    ) {
    }

    /**
     * Calculate the number of seconds to wait before retrying the job.
     *
     * @return int
     */
    public function backoff()
    {
        return [60, 120];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        Dispatcher::dispatch($this->order);
    }

    /**
     * Reports failure to the development team
     *
     * @param Exception $e
     *
     * @return void
     */
    public function failed(Exception $e): void
    {
        $this->order->status->state->transitionTo(Failed::class, 'Failed to dispatch delivery');
    }
}
