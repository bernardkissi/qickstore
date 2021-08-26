<?php

declare(strict_types=1);

namespace Domain\Delivery\Actions;

use Domain\Orders\Order;
use Spatie\MediaLibrary\Support\MediaStream;

class DeliveryAction
{
    /**
     * Download the file/s for a given order.
     *
     * @param Order $order
     * @return void
     */
    public function downloadMedia(Order $order)
    {
        //TODO: Add signature check to the controller

        $files = $order->load(['products.media']);

        if ($files->count()  > 1) {
            $downloads = $files->products->map(function ($file) {
                return $file->getMedia('products');
            })->unique();
            return MediaStream::create('download.zip')->addMedia(...$downloads);
        }
        return $files->products[0]->getMedia('products')->first();
    }
}
