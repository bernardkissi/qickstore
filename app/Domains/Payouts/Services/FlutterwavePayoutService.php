<?php

declare(strict_types=1);

namespace App\Domains\Payouts\Services;

use App\Domains\APIs\Flutterwave\Payouts\PayoutRequest;
use App\Domains\APIs\Flutterwave\Payouts\SendPayout;
use App\Domains\Payouts\Contract\PayableContract;
use App\Domains\Payouts\Events\PayoutCompleted;
use App\Domains\Payouts\Model\Payout;
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
