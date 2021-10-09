<?php

declare(strict_types=1);

namespace Domain\Disputes\States;

use Domain\Disputes\States\DisputeState;

class Resolved extends DisputeState
{
    /**
     * Property name of this state in DB
     *
     * @var string
     */
    public static $name = 'resolved';

    /**
     * Returns the paid state of an order
     *
     * @return string
     */
    public function status(): string
    {
        return 'Dispute has been resolved';
    }
}
