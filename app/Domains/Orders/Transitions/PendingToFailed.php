<?php

declare(strict_types=1);

namespace App\Domains\Orders\Transitions;

use App\Domains\Orders\Model\Order;
use Spatie\ModelStates\Transition;

class PendingToFailed extends Transition
{
    public function __construct(public Order $order, public string $error)
    {
    }

    public function handle()
    {
        $this->order->failed_at = now();
        $this->order->error_message = $this->message;
        $this->order->save();
    }
}
