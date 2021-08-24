<?php

namespace App\Domains\Delivery\Checkers;

use App\Domains\Delivery\Checkers\DeliveryChecker;
use App\Domains\Delivery\Notifications\RemindVendorToUpdateOrderNotification;
use App\Domains\Services\Notifications\Channels\SmsChannel;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class VendorDeliveryChecker implements DeliveryChecker
{
    /**
     * Remind vendors to update their orders
     *
     * @param array $payload
     * @return void
     */
    public static function getUpdates(array $payload): void
    {
        $data = static::getVendors($payload);
        $numbers = static::formatNumbersToString($data);

        Notification::route('mail', '5e97e062-959f-433f-b0dc-4833de15bda2@usehelo.cloud')
        ->route(SmsChannel::class, $numbers)
        ->notify(new RemindVendorToUpdateOrderNotification($numbers));
    }

    /**
     * Uniquely return all vendors to be notified of delivery updates
     *
     * @param array $payload
     * @return array
     */
    protected static function getVendors(array $payload): string
    {
        //TODO: Return unique vendor contacts these orders belongs to

        return collect($payload)->map(function ($delivery) {
            return ['0543063709', '0552377591', '0244224317'];
        })->unique()->values()->flatten();
    }

    /**
     * Format numbers to string to be passed into notification
     *
     * @param string $numbers
     * @return string
     */
    protected static function formatNumbersToString(string $numbers): string
    {
        $value = Str::replace(array('["','"]'), '', $numbers);
        return Str::replace('","', ',', $value);
    }
}
