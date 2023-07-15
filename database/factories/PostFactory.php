<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->words(nb: random_int(3, 10), asText: true),
            'body' => $this->faker->paragraphs(nb: random_int(3, 10), asText: true),
        ];
    }
}
