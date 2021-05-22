<?php

namespace App\Domains\Products\Product\Services\ProductImages;

trait ImageHandler
{
    /**
     * Uploads file to s3 bucket
     *
     * @param string $image
     *
     * @return void
     */
    public function toS3Bucket(string $image)
    {
        $this->addMediaFromRequest($image)
            ->storingConversionsOnDisk('s3')
            ->toMediaCollection('products');
    }
}
