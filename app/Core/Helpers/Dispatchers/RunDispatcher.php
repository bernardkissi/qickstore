<?php

declare(strict_types=1);

namespace App\Core\Helpers\Dispatchers;

use App\Core\Helpers\Dispatchers\Dispatcher;

class RunDispatcher
{
    public static function run(Dispatcher $dispatcher)
    {
        $dispatcher->dispatch();
    }
}
