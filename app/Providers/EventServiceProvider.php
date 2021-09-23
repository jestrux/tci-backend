<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

use App\Listeners\SaveSubscription;
use App\Listeners\SubscriptionPaid;
use App\Listeners\SubscriptionTerminated;
use ProtoneMedia\LaravelPaddle\Events\SubscriptionPaymentSucceeded;
use ProtoneMedia\LaravelPaddle\Events\SubscriptionCancelled;
use ProtoneMedia\LaravelPaddle\Events\SubscriptionCreated;

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
        SubscriptionCreated::class => [
            SaveSubscription::class
        ],
        SubscriptionCancelled::class => [
            SubscriptionTerminated::class
        ],
        // PaymentSucceeded::class => [
        //     SubscriptionPaid::class
        // ],
        SubscriptionPaymentSucceeded::class => [
            SubscriptionPaid::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
