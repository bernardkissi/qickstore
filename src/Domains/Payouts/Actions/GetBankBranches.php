<?php

declare(strict_types=1);

namespace Domain\Payouts\Actions;

use Integration\Flutterwave\Payouts\GetBranches;

class GetBankBranches
{
    public static function get(int $bankId): array
    {
        return GetBranches::build()->setPath("/banks/$bankId/branches")
            ->send()
            ->json();
    }
}
