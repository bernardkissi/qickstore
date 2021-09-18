<?php

declare(strict_types=1);

namespace Domain\Orders\Actions;

use Domain\Orders\Checkouts\Facade\Checkout;
use Domain\Orders\Events\OrderCreatedEvent;
use Domain\Payments\Facade\Payment;
use Illuminate\Support\Facades\DB;

class OrderCallback
{
    /**
     * checkout users order
     *
     * @param array $data
     * @return void
     */
    public function callback(array $data): void
    {
        // updat
    }
}
