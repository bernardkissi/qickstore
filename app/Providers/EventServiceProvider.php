<?php

namespace App\Providers;

use Domain\Orders\Events\OrderCreatedEvent;
use Domain\Orders\Listeners\OrderPaymentFailed;
use Domain\Orders\Listeners\OrderPaymentSuccessful;
use Domain\Orders\Listeners\OrderStateChangeListener;
use Domain\Payouts\Events\PayoutCompleted;
use Domain\Payouts\Listeners\PayoutNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Spatie\ModelStates\Events\StateChanged;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        StateChanged::class => [
            OrderPaymentSuccessful::class,
            OrderPaymentFailed::class,
            OrderStateChangeListener::class,
        ],

        PayoutCompleted::class => [
            PayoutNotification::class,
        ],

        OrderCreatedEvent::class => [
            //
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
    }
}