<?php

declare(strict_types=1);

namespace Domain\Disputes\Observers;

use Domain\Disputes\Dispute;
use Domain\Disputes\Jobs\PersitDisputeActionsJob;

class DisputeObserver
{
    /**
     * Handle the Dispute "created" event.
     *
     * @param Dispute  $dispute
     * @return void
     */
    public function created(Dispute $dispute): void
    {
        PersitDisputeActionsJob::dispatch(
            $dispute,
            action:'Dispute Created',
            message: 'Customer open dispute about his order'
        );
    }

    /**
     * Handle the Dispute "updated" event.
     *
     * @param Dispute  $dispute
     * @return void
     */
    public function updated(Dispute $dispute)
    {
        PersitDisputeActionsJob::dispatch(
            $dispute,
            action:'Merchant Responsed',
            message: $dispute->merchant_response
        );
    }

    /**
     * Handle the Dispute "deleted" event.
     *
     * @param Dispute  $dispute
     * @return void
     */
    public function deleted(Dispute $dispute)
    {
    }

    /**
     * Handle the Dispute "restored" event.
     *
     * @param  Dispute  $dispute
     * @return void
     */
    public function restored(Dispute $dispute)
    {
        //
    }

    /**
     * Handle the Dispute "force deleted" event.
     *
     * @param Dispute  $dispute
     * @return void
     */
    public function forceDeleted(Dispute $dispute)
    {
        //
    }
}
