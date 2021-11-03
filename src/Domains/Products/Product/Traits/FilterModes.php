<?php

declare(strict_types=1);

namespace Domain\Products\Product\Traits;

trait FilterModes
{
    public function mode($value): string
    {
        return match ($value) {
            'high' => '>',
            'low' => '<',
            default => '<=',
        };
    }
}
