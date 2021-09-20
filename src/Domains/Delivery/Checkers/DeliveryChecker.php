<?php

namespace Domain\Delivery\Checkers;

interface DeliveryChecker
{
    /**
     * Get updates of a delivery
     *
     * @param array $payload
     *
     * @return void
     */
    public static function getUpdates(array $payload): void;
}
