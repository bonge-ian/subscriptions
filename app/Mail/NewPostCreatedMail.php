<?php

namespace App\Mail;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class NewPostCreatedMail extends Mailable implements ShouldQueue, ShouldBeUnique
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public User $user, public Post $post)
    {
        $this->post->loadMissing('site');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Post Created Mail',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.new-post-created-mail',
            with: [
                'username' => $this->user->name,
                'post_title' => $this->post->title,
                'post_body' => $this->post->body,
                'site_title' => $this->post->site->title,
                'site_url' => $this->post->site->url,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function uniqueId(): string
    {
        return $this->post->id;
    }
}
