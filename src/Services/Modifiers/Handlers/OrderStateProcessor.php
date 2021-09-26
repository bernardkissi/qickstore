<?php

declare(strict_types=1);

namespace Service\Modifiers\Handlers;

use App\Helpers\Processor\RunProcessor;
use Domain\Orders\Processors\CancelledProcessor;
use Domain\Orders\Processors\CompletedProcessor;
use Domain\Orders\Processors\DeliveryProcessor;
use Domain\Orders\Processors\FailedProcessor;
use Domain\Orders\Processors\PaidProcessor;
use Domain\Orders\Processors\ProcessedProcessor;
use Domain\Orders\Processors\ShippedProcessor;
use Illuminate\Database\Eloquent\Model;
use Service\Modifiers\Handlers\Contract\StateProcessContract;

class OrderStateProcessor extends StateProcessContract
{
    public static function process(Model $model, string $state): void
    {
        $processor = match ($state) {
            'paid' => new PaidProcessor($model),
            'processing' => new ProcessedProcessor($model),
            'failed' => new FailedProcessor($model),
            'shipped'   => new ShippedProcessor($model),
            'delivered' => new DeliveryProcessor($model),
            'completed' => new CompletedProcessor($model),
            'cancelled' => new CancelledProcessor($model)
        };

        RunProcessor::run($processor);
    }
}
