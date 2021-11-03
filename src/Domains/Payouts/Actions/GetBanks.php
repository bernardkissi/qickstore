<?php

declare(strict_types=1);

namespace Domain\Payouts\Actions;

use Integration\Flutterwave\Payouts\GetBanks as Banks;

class GetBanks
{
    public static function get(string $countryCode): array
    {
        return Banks::build()->setPath("/banks/${countryCode}")
            ->send()
            ->json();
    }
}
