<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use App\Jobs\ProcessNewPostCreatedNotifications;

class NotifySubscribedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify-subscribed-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify all subscribed users when a post is created';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Cache::remember(
            'last_run',
            now()->addHours(2),
            fn () => $this->sendEmails(),
        );
    }

    public function sendEmails(): void
    {
        Post::query()->with('site.subscribers')
            ->whereDate('created_at', '>', Cache::get('last_run', now()))
            ->eachById(
                function (Post $post) {
                    return ProcessNewPostCreatedNotifications::dispatch($post)->onQueue('notification-emails');
                }
            );

    }
}
