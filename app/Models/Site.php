<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'url',
    ];

    //    protected $withCount = [
    //        'subscribers'
    //    ];

    public function posts(): HasMany
    {
        return $this->hasMany(related: Post::class, foreignKey: 'site_id');
    }

    public function canceledSubscribers(): BelongsToMany
    {
        return $this->subscribers()->whereNotNull('cancelled_at');
    }

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(
            related: User::class,
            table: 'subscriptions',
            foreignPivotKey: 'site_id',
            relatedPivotKey: 'user_id'
        )
            ->withPivot(columns: 'cancelled_at')->withTimestamps();
    }

    public function activeSubscribers(): BelongsToMany
    {
        return $this->subscribers()->whereNull('cancelled_at');
    }
}
