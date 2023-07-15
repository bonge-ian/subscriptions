<?php

namespace App\Listeners;

use App\Events\PostCreated;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Jobs\ProcessNewPostCreatedNotifications;

class SendNewPostCreatedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public $queue = 'notification-emails';

    public $delay = 60;

    public $tries = 5;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PostCreated $event): void
    {
        ProcessNewPostCreatedNotifications::dispatch($event->post)
            ->onQueue('notification-emails');

        Cache::put('last_inserted_post', $event->post->id);

    }
}
