<?php

declare(strict_types=1);

namespace App\Domains\Orders\Transitions;

use App\Domains\Orders\Model\Order;
use App\Domains\Orders\States\Failed;
use Spatie\ModelStates\Transition;

class PendingToFailed extends Transition
{
    public function __construct(public Order $order, public string $error)
    {
    }

    public function handle()
    {
        $this->order->state = new Failed($this->order);
        $this->order->failed_at = now();
        $this->order->error_message = $this->error;
        $this->order->save();
    }
}
