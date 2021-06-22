<?php

namespace App\Domains\Payouts\Dtos;

use const Cerbero\Dto\IGNORE_UNKNOWN_PROPERTIES;
use const Cerbero\Dto\PARTIAL;
use Cerbero\LaravelDto\Dto;

/**
 * The data transfer object for the Payment model.
 *
 * @property string $account_bank
 * @property string account_number
 * @property string $narration
 * @property string $currency
 * @property int $amount
 * @property string $provider
 * @property string $reference
 * @property string $beneficiary_name
 * @property string $destination_branch_code
 * @property string $beneficiary_name
 * @property string $callback_url
 */
class PayoutDto extends Dto
{
    /**
     * The default flags.
     *
     * @var int
     */
    protected static $defaultFlags = PARTIAL | IGNORE_UNKNOWN_PROPERTIES;
}
