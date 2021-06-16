<?php

namespace App\Domains\Delivery\Contract;

interface DeliveryResolvableContract
{
    /**
     * Process delivery of the order
     *
     * @return void
     */
    public function provide(string $string);
}
