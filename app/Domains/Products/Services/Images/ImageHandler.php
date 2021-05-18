<?php

namespace App\Domains\Products\Services\Images;

trait ImageHandler
{
   
    /**
     * Uploads file to s3 bucket
     *
     * @param string $image
     * @return void
     */
    public function toS3Bucket(string $image)
    {
        $this->addMediaFromRequest($image)
           ->toMediaCollection('products');

        // echo $this->getFirstMediaUrl('thumb');
    }
}
