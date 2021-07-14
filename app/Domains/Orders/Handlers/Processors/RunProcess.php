<?php


declare(strict_types=1);

namespace App\Domains\Orders\Handlers\Processors;

use App\Domains\Orders\Handlers\OrderProcessor;

class RunProcess
{
    public static function run(OrderProcessor $processor)
    {
        dd($processor->execute());
    }
}
