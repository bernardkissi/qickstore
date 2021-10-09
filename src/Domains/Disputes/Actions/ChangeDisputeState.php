<?php

declare(strict_types=1);

namespace Domain\Disputes\Actions;

use Domain\Disputes\Dispute;

class ChangeDisputeState
{
    /**
     * Change state of dispute
     *
     * @param Dispute $dispute
     * @param string $state
     * @return void
     */
    public static function change(Dispute $dispute, string $state): bool
    {
        $trans = $dispute->transitionDisputeTo($state);
        return $trans;
    }
}
