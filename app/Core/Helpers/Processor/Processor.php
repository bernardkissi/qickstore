<?php

declare(strict_types=1);

namespace App\Core\Helpers\Processor;

use Illuminate\Database\Eloquent\Model;

abstract class Processor
{
    /**
     * Returns a processor to handle the order.
     *
     * @return Processor
     */
    abstract public function getInstance(): Processor;

    /**
     * Execute the processor
     *
     * @param Model $model
     * @return void
     */
    public function execute(): void
    {
        $this->getInstance()->execute();
    }
}
