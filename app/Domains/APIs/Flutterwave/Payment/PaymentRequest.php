<?php

namespace App\Domains\APIs\Flutterwave\Payment;

use App\Domains\Payments\Dtos\PaymentDto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait PaymentRequest
{
    /**
     * Prepare user payment information
     *
     * @param Request $request
     *
     * @return PaymentDto
     */
    public static function data(Request $request): array
    {
        $data = [
                    'redirect_url' => route('home'),
                    'amount' => 3000,
                    'tx_ref' => (string) Str::uuid(),
                    'meta' => [
                        'order_id' => 'DEMO_ID',
                        'order_subtotal' => 3000,
                    ],
                    'customer' => [
                        'email' => 'bernardkissi18@gmail.com',
                        'phonenumber' => '0543063709',
                        'name' => 'Bernard Kissi',
                    ],
                    'customization' => [
                        'title' => 'MyShop',
                        'description' => 'Hair loss solution for people in the bank',
                        'logo' => 'company logo',
                    ],
                ];

        return PaymentDto::make($data)->toArray();
    }
}
