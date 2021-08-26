<?php

declare(strict_types=1);

namespace Domain\Orders\Traits;

trait ManagesOrderDelivery
{
    /**
     * Create order related delivery
     *
     * @param array $payload
     * @return void
     */
    public function createDelivery(array $payload): void
    {
        $this->delivery()->create($payload);
    }
}
