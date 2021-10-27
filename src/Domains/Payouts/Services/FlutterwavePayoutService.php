<?php

declare(strict_types=1);

namespace Domain\Payouts\Services;

use Domain\Payouts\Contract\PayableContract;
use Domain\Payouts\Dtos\PayoutDto;
use Domain\Payouts\Events\PayoutCompleted;
use Domain\Payouts\Payout;
use Illuminate\Support\Str;
use Integration\Flutterwave\Payouts\SendPayout;
use Throwable;

class FlutterwavePayoutService implements PayableContract
{

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
                        'payout_id' => $response['data']['id'],
                        'account_number' => $response['data']['account_number'],
                        'currency' => $response['data']['currency'],
                        'bank_name' => $response['data']['bank_name'],
                        'fullname' => $response['data']['full_name'],
                        'amount_requested' => $response['data']['amount'],
                        'transaction_fee' => $response['data']['fee'],
                        'status' => $response['data']['status'],
                        'requires_approval' => $response['data']['requires_approval'],
                        'is_approved' => $response['data']['is_approved'],
                        'reference' => $response['data']['reference'],
                    ]
                );

                event(new PayoutCompleted($response['data']));
            }
        })->catch(function (Throwable $e) {
            throw new \Exception($e->getMessage());
        });
    }


    /**
     * Prepare merchant payout request
     *
     * @param Request $request
     *
     * @return array // Add customer
     */
    public static function data(array $payload): array
    {
        $data = [
            'account_bank' => 'MTN',
            'account_number' => '233543063709',
            'amount' => $payload['amount'],
            'narration' => 'New GHS momo transfer',
            'currency' => 'GHS',
            'reference' => (string) Str::uuid(),
            'beneficiary_name' => 'Bernard Kissi',
            'callback_url' => 'https://webhook.site/479ed5cd-c971-434d-a83a-ae5bd822a5e3',
        ];

        $payload['type'] === 'bank' ? ['destination_branch_code' => 'GH280103'] : [];

        $req = array_merge($data, $payload);

        return PayoutDto::make($req)->toArray();
    }
}
