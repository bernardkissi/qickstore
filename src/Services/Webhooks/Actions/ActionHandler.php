<?php

declare(strict_types=1);

namespace Service\Webhooks\Actions;

interface ActionHandler
{
    public static function handle(array $payload): void;
}
