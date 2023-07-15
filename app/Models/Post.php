<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'body',
    ];

    protected static function booting(): void
    {
        static::creating(static fn ($post) => $post->slug = Str::slug($post->title));
    }

    protected function slug(): Attribute
    {
        return Attribute::set(
            set: fn (string $value): string => $this->id.'-'.Str::slug($value)
        );
    }

    protected static function booted(): void
    {
        static::created(static fn ($post) => $post->update(['slug' => $post->title]));
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(related: Site::class, foreignKey: 'site_id');
    }
}
