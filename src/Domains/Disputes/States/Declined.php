<?php

declare(strict_types=1);

namespace Domain\Disputes\States;

class Declined extends DisputeState
{
    /**
     * Property name of this state in DB
     *
     * @var string
     */
    public static $name = 'declined';

    /**
     * Returns the paid state of an order
     *
     * @return string
     */
    public function status(): string
    {
        return 'Dispute has been declined by merchant';
    }
}
