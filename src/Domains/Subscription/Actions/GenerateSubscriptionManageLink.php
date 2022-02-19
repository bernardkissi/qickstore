<?php

declare(strict_types=1);

namespace Domain\Subscription\Actions;

use Integration\Paystack\Subscriptions\GenerateSubscriptionLink;

class GenerateSubscriptionManageLink
{
    public static function execute(string $subscriptionCode): string
    {
        $res = GenerateSubscriptionLink::build()
        ->setPath('/subscription/'.$subscriptionCode.'/manage/link/')
        ->send()->object();

        return $res->data->link;
    }
}
