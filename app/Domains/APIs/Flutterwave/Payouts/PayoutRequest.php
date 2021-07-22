<?php
declare(strict_types=1);

namespace App\Domains\APIs\Flutterwave\Payouts;

use App\Domains\Payouts\Dtos\PayoutDto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait PayoutRequest
{
    /**
     * Prepare merchant payout request
     *
     * @param Request $request
     *
     * @return array
     */
    public static function data(array $req): array
    {
        $data = [

            'account_bank' => 'MTN',
            'account_number' => '233543063709',
            'amount' => $req['amount'],
            'narration' => 'New GHS momo transfer',
            'currency' => 'GHS',
            'reference' => (string) Str::uuid(), //TODO : should include store id + uuid
            'beneficiary_name' => 'Bernard Kissi',
            'callback_url' => 'https://webhook.site/05ec9b52-99b1-4b10-9134-a1ae1dc61a1b',
            // "destination_branch_code" => "GH280103",
        ];

        return PayoutDto::make($data)->toArray();
    }
}