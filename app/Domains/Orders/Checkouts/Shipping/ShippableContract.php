<?php

declare(strict_types=1);

namespace App\Domains\Orders\Checkouts\Shipping;

interface ShippableContract
{
    /**
     * Download single files
     *
     * @return Media
     */
    public function delivery(): string;
}
