<?php

namespace Domain\Payments\Dtos;

use Cerbero\LaravelDto\Dto;
use const Cerbero\Dto\IGNORE_UNKNOWN_PROPERTIES;
use const Cerbero\Dto\PARTIAL;
use Domain\Orders\Dtos\OrderData;

/**
 * The data transfer object for the Payment model.
 *
 * @property string $currency
 * @property int $id
 * @property string $reference
 * @property string|null $cardType
 * @property string|null $subaccount
 * @property string|null $transRef
 * @property string $status
 * @property int $amount
 * @property string $provider
 * @property string $payment_methods
 * @property array $channels
 * @property array $customization
 * @property array $subaccounts
 * @property array $customer
 * @property string $redirect_url
 * @property bool $has_subscription
 * @property int $invoice_limit
 * @property array $order
 */
class PaymentDto extends Dto
{
    /**
     * The default flags.
     *
     * @var int
     */
    protected static $defaultFlags = PARTIAL | IGNORE_UNKNOWN_PROPERTIES;
}
