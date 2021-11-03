<?php

declare(strict_types=1);

namespace App\Traits;

trait ResolveTrait
{
    /**
     * Resolves the service to be used when resolving a dependency in the container
     *
     * @param string $key
     * @param string $defaultkey
     * @param string $config_path
     *
     * @return string
     */
    protected function resolveService(string $key, ?string $defaultkey, string $config_path): string
    {
        $service = request($key, $defaultkey);
        return config("${config_path}.${service}");
    }
}
