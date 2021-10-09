<?php

namespace Domain\Disputes\Observers;

use Domain\Disputes\DisputeAction;
use Domain\Refunds\Jobs\PersitDisputeActionsJob;

class DisputeActionObserver
{
    /**
     * Handle the DisputeAction "created" event.
     *
     * @param DisputeAction  $disputeAction
     * @return void
     */
    public function created(DisputeAction $disputeAction)
    {
        PersitDisputeActionsJob::dispatch(
            $disputeAction,
            action: $disputeAction->action,
            message: $disputeAction->message,
        );
    }

    /**
     * Handle the DisputeAction "updated" event.
     *
     * @param DisputeAction  $disputeAction
     * @return void
     */
    public function updated(DisputeAction $disputeAction)
    {
        PersitDisputeActionsJob::dispatch(
            $disputeAction,
            action: "Re: $disputeAction->action",
            message: $disputeAction->message,
        );
    }

    /**
     * Handle the DisputeAction "deleted" event.
     *
     * @param DisputeAction  $disputeAction
     * @return void
     */
    public function deleted(DisputeAction $disputeAction)
    {
        //
    }

    /**
     * Handle the DisputeAction "restored" event.
     *
     * @param DisputeAction  $disputeAction
     * @return void
     */
    public function restored(DisputeAction $disputeAction)
    {
        //
    }

    /**
     * Handle the DisputeAction "force deleted" event.
     *
     * @param DisputeAction  $disputeAction
     * @return void
     */
    public function forceDeleted(DisputeAction $disputeAction)
    {
        //
    }
}
