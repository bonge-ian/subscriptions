<?php

namespace Database\Seeders;

use App\Models\Site;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Collection;

class SubscriptionSeeder extends Seeder
{
    public function run(): void
    {
        User::query()
            ->chunk(
                10,
                static fn (Collection $users) => $users->each(
                    static fn (User $user) => $user->subscriptions()
                        ->syncWithPivotValues(
                            Site::query()->inRandomOrder()->limit(random_int(1, 6))->get('id'),
                            [
                                'cancelled_at' => fake()->optional()->dateTimeBetween(today(), now()->endOfDay()),
                            ],
                        )
                )
            );
    }
}
