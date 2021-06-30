<?php

declare(strict_types=1);

namespace App\Domains\Payouts\Services;

use App\Domains\APIs\Flutterwave\Payouts\PayoutRequest;
use App\Domains\APIs\Flutterwave\Payouts\SendPayout;
use App\Domains\Payouts\Contract\PayableContract;
use App\Domains\Payouts\Events\PayoutCompleted;
use App\Domains\Payouts\Model\Payout;
use Spatie\QueueableAction\QueueableAction;

class FlutterwavePayoutService implements PayableContract
{
    use PayoutRequest, QueueableAction;

    /**
     * Send payout request to our payment gateway
     *
     * @return array
     */
    public function pay(array $data): object
    {
        return SendPayout::build()
        ->withData(static::data($data))
        ->send();
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
