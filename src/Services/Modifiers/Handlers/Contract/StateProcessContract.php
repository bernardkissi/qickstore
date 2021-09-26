<?php

declare(strict_types=1);

namespace Service\Modifiers\Handlers\Contract;

use Illuminate\Database\Eloquent\Model;

abstract class StateProcessContract
{
    abstract public static function process(Model $model, string $state): void;
}
