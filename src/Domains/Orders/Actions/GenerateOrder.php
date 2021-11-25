<?php

declare(strict_types=1);

namespace Domain\Orders\Actions;

class GenerateOrder
{
    public static function execute(array $data): void
    {
        var_dump('generating order');
    }
}
