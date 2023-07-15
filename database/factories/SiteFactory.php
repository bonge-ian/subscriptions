<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Site>
 */
class SiteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->catchPhrase(),
            'url' => $this->faker->unique()->url(),
        ];
    }
}
