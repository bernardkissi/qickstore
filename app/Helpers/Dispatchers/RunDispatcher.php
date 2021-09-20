<?php

declare(strict_types=1);

namespace App\Helpers\Dispatchers;

class RunDispatcher
{
    public static function run(Dispatcher $dispatcher)
    {
        $dispatcher->dispatch();
    }
}
