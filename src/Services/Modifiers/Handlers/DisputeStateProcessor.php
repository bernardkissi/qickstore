<?php

declare(strict_types=1);

namespace Service\Modifiers\Handlers;

use App\Helpers\Processor\RunProcessor;
use Domain\Disputes\Processors\AcceptedProcessor;
use Domain\Disputes\Processors\DeclinedProcessor;
use Domain\Disputes\Processors\OpenProcessor;
use Domain\Disputes\Processors\ResolvedProcessor;
use Illuminate\Database\Eloquent\Model;
use Service\Modifiers\Handlers\Contract\StateProcessContract;

class DisputeStateProcessor extends StateProcessContract
{
    public static function process(Model $model, string $state): void
    {
        $processor = match ($state) {
            'open' => new OpenProcessor($model),
            'accepted' => new AcceptedProcessor($model),
            'declined'    => new DeclinedProcessor($model),
            'resolved'   => new ResolvedProcessor($model),
        };

        RunProcessor::run($processor);
    }
}
