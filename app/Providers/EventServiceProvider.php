<?php

namespace App\Providers;

use App\Events\PostCreated;
use App\Listeners\EmailSent;
use Illuminate\Auth\Events\Registered;
use App\Listeners\SendNewPostCreatedNotification;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        PostCreated::class => [
            SendNewPostCreatedNotification::class,
        ],
        NotificationSent::class => [
            EmailSent::class,
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
