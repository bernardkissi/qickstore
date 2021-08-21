<?php

namespace App\Domains\Delivery\Dispatchers;

use App\Domains\Delivery\Contract\DeliverableContract;
use App\Domains\Delivery\Notifications\SendFileLinkToEmailNotification;
use App\Domains\Orders\Model\Order;
use Illuminate\Support\Facades\Notification;

class FileDelivery implements DeliverableContract
{
    /**
     * di9spatch the delivery to the agent
     *
     * @return void
     */
    public static function dispatch(Order $order): void
    {
        // $amount = ShippingProvider::where('slug', $order->service)?->first()->price;
        // $data = [
        //     'service' => $order->service,
        //     'reference' => Str::uuid(),
        //     'tracking_code' => Str::random(6),
        //     'amount' =>  $amount ?? 0,
        //     'instructions' => $order->instructions ?? null
        // ];
        //$order->createOrderDelivery($data);

        Notification::route('mail', 'bernardkissi18@gmail.com')
            ->notify(new SendFileLinkToEmailNotification($order));
    }
}
