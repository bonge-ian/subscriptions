<?php

namespace App\Jobs;

use App\Models\Post;
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
        dd($this->post);
        $this->post->site->subscribers->each?->sendNewPostCreatedNotification(post: $this->post);
    }

    public function uniqueId(): string
    {
        return $this->post->slug.'_'.$this->post->id;
    }
}
