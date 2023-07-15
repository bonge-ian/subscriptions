<?php

namespace App\Listeners;

use App\Events\PostCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
        $event->post->site->subscribers->each->sendNewPostCreatedNotification(post: $event->post);
    }
}
