<?php

declare(strict_types=1);

namespace Service\Modifiers\Handlers;

use App\Helpers\Processor\RunProcessor;
use Domain\Subscription\Processors\ActiveProcessor;
use Domain\Subscription\Processors\DisabledProcessor;
use Domain\Subscription\Processors\NotRenewingProcessor;
use Domain\Subscription\Processors\PendingProcessor;
use Domain\Subscription\States\PaymentFailed;
use Illuminate\Database\Eloquent\Model;
use Service\Modifiers\Handlers\Contract\StateProcessContract;

class SubscriptionStateProcessor extends StateProcessContract
{
    public static function process(Model $model, string $state): void
    {
        $processor = match ($state) {
            'active' => new ActiveProcessor($model),
            'disabled' => new DisabledProcessor($model),
            'not-renewing' => new NotRenewingProcessor($model),
            'pending' => new PendingProcessor($model),
            'payment-failed' => new PaymentFailed($model)
        };

        RunProcessor::run($processor);
    }
}
