<?php

namespace App\Providers;

use Domain\Disputes\Dispute;
use Domain\Disputes\Observers\DisputeObserver;
use Domain\Orders\Events\OrderCreatedEvent;
use Domain\Orders\Listeners\CreatePayment;
use Domain\Payouts\Events\PayoutCompleted;
use Domain\Payouts\Listeners\PayoutNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Service\Modifiers\StateChangeProcessor;
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
            StateChangeProcessor::class,
        ],

        PayoutCompleted::class => [
            PayoutNotification::class,
        ],

        OrderCreatedEvent::class => [
            // EmptyCart::class,
            CreatePayment::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Dispute::observe(DisputeObserver::class);
    }
}
