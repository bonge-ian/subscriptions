<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Notifications\NewPostCreatedNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $withCount = [
        'subscriptions'
    ];

    public function subscriptions(): BelongsToMany
    {
        return $this->belongsToMany(
            related: Site::class,
            table: 'subscriptions',
            foreignPivotKey: 'user_id',
            relatedPivotKey: 'site_id'
        )->withPivot(columns: 'cancelled_at')->withTimestamps();
    }

    public function sendNewPostCreatedNotification(Post $post): void
    {
        $this->notify(new NewPostCreatedNotification(user: $this, post: $post));
    }
}
