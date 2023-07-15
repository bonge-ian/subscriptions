<?php

namespace App\Listeners;

use App\Models\SentEmail;
use App\Notifications\NewPostCreatedNotification;
use Illuminate\Notifications\Events\NotificationSent;

class EmailSent
{
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
    public function handle(NotificationSent $event): void
    {
        if ($event->notification instanceof NewPostCreatedNotification) {
            SentEmail::query()->forceCreate([
                'user_id' => $event->notification->user->id,
                'post_id' => $event->notification->post->id,
                'sent_at' => now(),
            ]);
        }
    }
}
