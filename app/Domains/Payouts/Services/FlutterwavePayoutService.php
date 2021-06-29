<?php

declare(strict_types=1);

namespace App\Domains\Payouts\Services;

use App\Domains\Payouts\Contract\PayableContract;
use App\Domains\Payouts\Events\PayoutCompleted;
use App\Domains\Payouts\Model\Payout;
use App\Domains\Payouts\Traits\PayoutApiData;
use Illuminate\Support\Facades\Http;
use Spatie\QueueableAction\QueueableAction;

class FlutterwavePayoutService implements PayableContract
{
    use PayoutApiData, QueueableAction;

    /**
     * Send payout request to our payment gateway
     *
     * @return array
     */
    public function pay(array $data): object
    {
        $api = static::payoutsApiData($data)->toArray();

        $response = Http::withToken(env('FLUTTERWAVE_SEC_KEY'))
            ->post(config('payments.flutterwave.payout'), $api);

        if ($response->failed()) {
            throw new \Exception('Oops! something went wrong with payout');
        }

        return $response;
    }

    /**
     * Makes payout on behalf of the merchant
     *
     * @param array $data
     *
     * @return void
     */
    public function execute(array $data): void
    {
        $response = $this->pay($data);

        // TODO: dispatch an event will handle creating payout and send payout notification to the merchant
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

            event(new PayoutCompleted($data['shop']));
        }
    }
}
