<?php

declare(strict_types=1);

namespace Domain\Payments\Actions;

class CreatePayment
{
    public static function execute(array $data): void
    {
        var_dump('creating payment');
    }
}
