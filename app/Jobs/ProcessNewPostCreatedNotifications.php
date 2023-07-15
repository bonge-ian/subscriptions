<?php

namespace App\Jobs;

use App\Models\Post;
use App\Models\User;
use App\Models\SentEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProcessNewPostCreatedNotifications implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $tries = 3;

    public $backoff = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(public Post $post)
    {
        //        $this->post->loadMissing('site.subscribers');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->post->site->subscribers->each(function (User $subscriber) {
            if (!$this->emailAlreadySent($subscriber->id)) {
                $subscriber->sendNewPostCreatedNotification(post: $this->post);
            }
        });
    }

    protected function emailAlreadySent(int $user_id): bool
    {
        return SentEmail::query()->where('post_id', '=', $this->post->id)
            ->where('user_id', '=', $user_id)
            ->exists();
    }

    public function uniqueId(): string
    {
        return $this->post->slug.'_'.$this->post->id;
    }
}
