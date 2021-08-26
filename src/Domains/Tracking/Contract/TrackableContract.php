<?php

namespace Domain\Tracking\Contract;

interface TrackableContract
{
    /**
     * Track and change state of the trackable
     *
     * @return void
     */
    public function track(): string;
}
