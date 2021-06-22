<?php

declare(strict_types=1);

namespace App\Domains\Payouts\Services;

use App\Domains\Payouts\Contract\PayableContract;
use App\Domains\Payouts\Traits\PayoutApiData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FlutterwavePayoutService implements PayableContract
{
    use PayoutApiData;
    /**
     * Send payout request to our payment gateway
     *
     * @return array
     */
    public function pay(Request $request): array
    {
        $data = static::payoutsApiData($request)->toArray();

        $response = Http::withToken(env('FLUTTERWAVE_SEC_KEY'))
            ->post(config('payments.flutterwave.payout'), $data);

        if ($response->failed()) {
            throw new \Exception('Oops! something went wrong with payout');
        }

        return $response->json();
    }
}
