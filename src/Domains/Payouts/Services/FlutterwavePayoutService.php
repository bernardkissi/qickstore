<?php

declare(strict_types=1);

namespace Domain\Payouts\Services;

use Domain\APIs\Flutterwave\Payouts\PayoutRequest;
use Domain\Payouts\Contract\PayableContract;
use Domain\Payouts\Events\PayoutCompleted;
use Domain\Payouts\Payout;
use Integration\Flutterwave\Payouts\SendPayout;
use Throwable;

class FlutterwavePayoutService implements PayableContract
{
    use PayoutRequest;

    /**
     * Send payout request to our payment gateway
     *
     * @return array
     */
    public function pay(array $data): void
    {
        dispatch(function () use ($data) {
            $response = SendPayout::build()
            ->withData(static::data($data))
            ->send();

            if ($response->successful()) {
                Payout::create(
                    [
                        'payout_id' => '0000',
                        'account_number' => $response['data']['account_number'],
                        'bank_name' => $response['data']['bank_name'],
                        'fullname' => $response['data']['full_name'],
                        'amount_requested' => $response['data']['amount'],
                        'transaction_fee' => $response['data']['fee'],
                        'status' => $response['data']['status'],
                        'reference' => $response['data']['reference'],
                    ]
                );

                event(new PayoutCompleted($response['data']['shop']));
            }
        })->catch(function (Throwable $e) {
            //TODO: send failed notification to vendor payout failed try again later
        });
    }
}
