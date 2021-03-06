<?php

declare(strict_types=1);

namespace Service\Webhooks\Actions\Paystack;

use Domain\Orders\Actions\GenerateOrder;
use Domain\Payments\Actions\CreatePayment;
use Domain\Payments\Actions\UpdatePayment;
use Domain\Subscription\Actions\CreateProductSubsctription;
use Illuminate\Support\Facades\Bus;
use Service\Webhooks\Actions\ActionHandler;

class PaymentProcessor implements ActionHandler
{
    public static function handle(array $payload): void
    {
        dump($payload);
        $subscription = array_key_exists('has_subscription', $payload['data']['metadata']) ?? false;
        $has_subscription = $subscription ? $payload['data']['metadata']['has_subscription'] : false;
        $plan = $payload['data']['plan'];

        if (($subscription && $has_subscription) || ! empty($plan)) {
            match (empty($plan)) {
                true => static::doesntHavePlan($payload),
                false => static::hasPlan($payload),
            };
        } else {
            UpdatePayment::execute($payload);
        }
    }

    /**
     * Runs when payment has subscription is true but no has plan
     *
     * @param array $payload
     *
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
     * Runs when payment is a subscription payment and has a plan
     *
     * @param array $payload
     *
     * @return void
     */
    private static function hasPlan(array $payload): void
    {
        Bus::chain([
            fn () => GenerateOrder::execute($payload),
            fn () => CreatePayment::execute($payload),
        ])->dispatch();
    }
}
