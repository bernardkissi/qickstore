<?php

declare(strict_types=1);

namespace App\Domains\Payouts\Services;

use App\Domains\Payouts\Contract\PayableContract;
use App\Domains\Payouts\Model\Payout;
use App\Domains\Payouts\Traits\PayoutApiData;
use Illuminate\Http\Request;
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
    public function pay(array $data = []): array
    {
        $data = static::payoutsApiData($data)->toArray();

        $response = Http::withToken(env('FLUTTERWAVE_SEC_KEY'))
            ->post(config('payments.flutterwave.payout'), $data);

        if ($response->failed()) {
            throw new \Exception('Oops! something went wrong with payout');
        }

        return $response->json();
    }


    public function execute(array $req): void
    {
        $data = static::payoutsApiData($req)->toArray();

        $response = Http::withToken(env('FLUTTERWAVE_SEC_KEY'))
            ->post(config('payments.flutterwave.payout'), $data);

        if ($response->failed()) {
            throw new \Exception('Oops! something went wrong with payout');
        }

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
                    'reference' => $response['data']['reference']
                ]
            );
        }
    }
}


//  $table->integer('payout_id');
//             $table->string('account_number');
//             $table->string('bank_name');
//             $table->string('fullname');
//             $table->string('currency')->default('GHS');
//             $table->integer('amount_requested');
//             $table->integer('transaction_fee');
//             $table->string('status');
//             $table->string('reference');
//             $table->string('narration')->nullable();
//             $table->boolean('requires_approval')->default(0);
//             $table->boolean('is_approved')->default(0);
//             $table->string('error')->nullable();
