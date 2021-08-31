<?php

declare(strict_types=1);

namespace App\Helpers\Processor;

use App\Core\Helpers\Processor\Processor;

class RunProcessor
{
    public static function run(Processor $processor)
    {
        $processor->execute();
    }
}
