<?php

declare(strict_types=1);

namespace Domain\Disputes\States;

class Open extends DisputeState
{
    /**
     * Property name of this state in DB
     *
     * @var string
     */
    public static $name = 'open';

    /**
     * Returns the paid state of an order
     *
     * @return string
     */
    public function status(): string
    {
        return 'Awaiting merchant response';
    }
}
