<?php

namespace App\Core\Providers;

use App\Domains\Orders\Events\OrderCreatedEvent;
use App\Domains\Orders\Listeners\OrderStateChangeListener;
use App\Domains\Payouts\Events\PayoutCompleted;
use App\Domains\Payouts\Listeners\PayoutNotification;
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
