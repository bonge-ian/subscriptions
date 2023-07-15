<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Site;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        Post::factory()
            ->count(40)
            ->sequence(fn (Sequence $sequence) => ['site_id' => Site::query()->pluck('id')->random()])
            ->create();
    }
}
