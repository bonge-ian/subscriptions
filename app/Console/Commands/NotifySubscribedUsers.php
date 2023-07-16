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
        Post::query()
            ->with('site.activeSubscribers')
            ->doesntHave('sentMails')
            ->when(Cache::has('last_run'), fn ($query) => $query->where('created_at', '>', Cache::get('last_run')))
            ->eachById(
                function (Post $post) {
                    return ProcessNewPostCreatedNotifications::dispatchIf(
                        $post->site->subscribers->isNotEmpty(),
                        $post
                    )
                        ->onQueue('notification-emails');
                }
            );

        Cache::put('last_run', now());

        return 0;
    }

}
