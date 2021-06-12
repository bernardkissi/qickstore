<?php

declare(strict_types=1);

namespace App\Domains\Orders\Checkouts\Downloading;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\MediaStream;

interface DownloadableContract
{
    /**
     * Download single files
     *
     * @return Media
     */
    public function download(): string;

    /**
     * Download multiples files
     *
     * @return MediaStream
     */
    public function downloadFiles(): string;
}
