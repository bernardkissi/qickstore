<?php

declare(strict_types=1);

namespace Service\Webhooks;

interface WebhookAction
{
    /**
     * Actions to process the webhook data
     *
     * @param array $data
     *
     * @return void
     */
    public static function process(array $data): void;
}
