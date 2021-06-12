<?php

declare(strict_types=1);

namespace App\Domains\Orders\Checkouts;

use App\Domains\Cart\Services\Cart;
use App\Domains\Orders\Model\Order;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\MediaStream;

abstract class CheckOutService
{
    /**
     * Create customer order
     *
     * @return void
     */
    abstract public function createOrder(Cart $cart): Order;

    /**
     * Pay for the order
     *
     * @return string
     */
    abstract public function payOrder(): string;

    /**
     * Deliver customer order
     *
     * @return void
     */
    abstract public function dispatchOrder(): string;
}
