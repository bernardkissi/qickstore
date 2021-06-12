<?php

declare(strict_types=1);

namespace App\Domains\Orders\Checkouts\Downloading;

use App\Domains\Cart\Services\Cart;
use App\Domains\Orders\Checkouts\CheckOutService;
use App\Domains\Orders\Checkouts\Downloading\DownloadableContract;
use App\Domains\Orders\Model\Order;
use App\Domains\User\User;
use App\Domains\User\Visitor;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\MediaStream;

class DownloadService extends CheckOutService implements DownloadableContract
{

    /**
     * Class constructor
     *
     * @param mixed $customer
     */
    public function __construct(public User|Visitor $customer)
    {
    }

    /**
     * Persit user order into datastore
     *
     * @return void
     */
    public function createOrder(Cart $cart): Order
    {
        $order = $this->customer->orders()->create(['subtotal' => $cart->total()->getAmount()]);
        $order->products()->sync($this->cart->products()->toCollect());
        return $order;
    }

    /**
     * Runs payment for the pending order
     *
     * @return string
     */
    public function payOrder(): string
    {
        return 'paying for download order ....';
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function dispatchOrder(): string
    {
        return 'dispatching order ..';
    }

    /**
     * Downloads a single resource
     *
     * @return string
     */
    public function download(): string
    {
        return 'downloading file ..';
    }

    /**
     * Download multiple resource
     *
     * @return string
     */
    public function downloadFiles(): string
    {
        return 'downloading files ..';
    }
}
