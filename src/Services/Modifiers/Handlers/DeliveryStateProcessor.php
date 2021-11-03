<?php

declare(strict_types=1);

namespace Service\Modifiers\Handlers;

use App\Helpers\Processor\RunProcessor;
use Domain\Delivery\Processors\AssignedProcessor;
use Domain\Delivery\Processors\DeliveredProcessor;
use Domain\Delivery\Processors\DeliveringProcessor;
use Domain\Delivery\Processors\FailedProcessor;
use Domain\Delivery\Processors\PickedProcessor;
use Domain\Delivery\Processors\PickingProcessor;
use Illuminate\Database\Eloquent\Model;
use Service\Modifiers\Handlers\Contract\StateProcessContract;

class DeliveryStateProcessor extends StateProcessContract
{
    public static function process(Model $model, string $state): void
    {
        $processor = match ($state) {
            'assigned' => new AssignedProcessor($model),
            'pickedup' => new PickedProcessor($model),
            'pickingup' => new PickingProcessor($model),
            'delivering' => new DeliveringProcessor($model),
            'delivered' => new DeliveredProcessor($model),
            'failed' => new FailedProcessor($model),
        };

        RunProcessor::run($processor);
    }
}
