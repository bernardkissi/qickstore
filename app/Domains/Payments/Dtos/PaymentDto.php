<?php

namespace App\Domains\Payments\Dtos;

use App\Domains\Orders\Model\Dtos\OrderData;
use Cerbero\LaravelDto\Dto;

use const Cerbero\Dto\IGNORE_UNKNOWN_PROPERTIES;
use const Cerbero\Dto\PARTIAL;

/**
 * The data transfer object for the Payment model.
 * @property string $currency
 * @property int $id
 * @property int $orderId
 * @property string $txRef
 * @property string|null $cardType
 * @property string|null $subaccount
 * @property string|null $providerReference
 * @property string $status
 * @property int $amount
 * @property string $provider
 * @property string $channel
 * @property string $payment_options
 * @property array $customization
 * @property array $subaccounts
 * @property array $customer
 * @property array $meta
 * @property string $redirect_url
 * @property OrderData $order
 */
class PaymentDto extends Dto
{
    /**
     * The default flags.
     *
     * @var int
     */
    protected static $defaultFlags = PARTIAL | IGNORE_UNKNOWN_PROPERTIES;

    /**
     * Default values
     *
     * @var array
     */
    protected static $defaultValues = [

        'currency' => 'GHS',
        'payment_options' => 'mobilemoney,card,paypal',
        'subaccounts' => [
            [
                'id' => 'RS_2F2994AA79A4EA872478C535F268A884',
                'transaction_charge_type' => "percentage",
                'transaction_charge' =>  0.09
            ]
        ],
    ];
}
