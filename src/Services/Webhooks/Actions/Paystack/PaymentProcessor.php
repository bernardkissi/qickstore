<?php

declare(strict_types=1);

namespace Service\Webhooks\Actions\Paystack;

use Domain\Orders\Actions\GenerateOrder;
use Domain\Payments\Actions\CreatePayment;
use Domain\Payments\Actions\UpdatePayment;
use Domain\Subscription\Actions\CreateProductSubsctription;
use Domain\Subscription\Actions\UpdateProductSubscription;
use Exception;

use function PHPUnit\Framework\throwException;
use Illuminate\Support\Facades\Bus;

class PaymentProcessor
{
    public static function handle(array $payload): void
    {
        $subscription = $payload['data']['metadata']['has_subscription']  === 'true' ? true : false;
        $plan = $payload['data']['plan'];

        if ($subscription === true || is_null($plan) !== false) {
            match (empty($plan)) {
                true => static::doesntHavePlan($payload),
                false => static::hasPlan($payload),
            };
        } else {
            UpdatePayment::execute($payload);
        }
    }

    /**
     * Runs when payment has subscription but no has plan
     *
     * @param array $payload
     * @return void
     */
    private static function doesntHavePlan(array $payload): void
    {
        Bus::chain([
            fn () => UpdatePayment::execute($payload),
            fn () => CreateProductSubsctription::execute($payload),
        ])->dispatch();
    }

    /**
     * Runs when payment already has a subscription plan
     *
     * @param array $payload
     * @return void
     */
    private static function hasPlan(array $payload): void
    {
        Bus::chain([
            fn () => CreatePayment::execute($payload),
            fn () => UpdateProductSubscription::execute($payload),
            fn () => GenerateOrder::execute($payload),
        ])->dispatch();
    }
}
