<?php

declare(strict_types=1);

namespace App\Core\Helpers\Transitions;

interface TransitionableMapper
{
    /**
     * Map external states to internal state
     *
     * @param string $state
     * @return string
     */
	public function map(string $state): string;
}
