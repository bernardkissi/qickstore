<?php

namespace App\Domains\Payments\Gateways;

use App\Domains\Payments\Contract\PaymentableContract;
use App\Domains\Payments\Traits\RaveApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Flutterwave implements PaymentableContract
{
    use RaveApi;
    /**
     * Charge the user through flutterwave gateway
     *
     * @param Request $request
     * @return array
     */
    public function charge(Request $request): array
    {
        $data = static::apiData($request)->toArray();

        $response = Http::withToken(env('FLUTTERWAVE_SEC_KEY'))
            ->post(config('payments.flutterwave'), $data);

        if ($response->failed()) {
            throw new \Exception('we couldnt complete your payment. try again later');
        }

        return $response->json();
    }


    public function payout()
    {
    }

    public function track()
    {
    }
}
