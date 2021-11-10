<?php

declare(strict_types=1);

namespace Service\Webhooks\Actions\Paystack;

use Carbon\Carbon;
use Domain\Payments\Actions\CreatePayment;
use Domain\Payments\Actions\UpdatePayment;
use Domain\Payments\Payment;
use Domain\Subscription\Actions\CreateProductSubsctription;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class PaymentProcessor
{
    public static function handle(array $payload): void
    {
        $subscription = $payload['data']['metadata']['has_subscription']  === 'true' ? true : false;
        $plan = $payload['data']['plan'];

        if ($subscription === true || is_null($plan) !== false) {
            if (empty($plan)) {
                Bus::chain([
                    fn () => (new UpdatePayment())->execute($payload),
                    fn () => (new CreateProductSubsctription())->execute($payload),
                ])->dispatch();
            }

            if ($plan) {
                Bus::chain([
                    fn () => (new CreatePayment())->execute($payload),
                    fn () => (new CreateProductSubsctription())->execute($payload),
                ])->dispatch();
            }
        } else {
            (new UpdatePayment())->execute($payload);
        }
    }
}
