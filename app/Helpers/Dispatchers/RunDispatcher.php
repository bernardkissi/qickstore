<?php

declare(strict_types=1);

namespace App\Helpers\Dispatchers;

use App\Core\Helpers\Dispatchers\Dispatcher;

class RunDispatcher
{
    public static function run(Dispatcher $dispatcher)
    {
        $dispatcher->dispatch();
    }
}
