<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Podcast;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id ?? 1,
            'podcast_id' => Podcast::inRandomOrder()->first()->id ?? 1,
            'body' => $this->faker->sentence(12),
            'parent_id' => null,
        ];
    }

    private function getRandomParentIdOrNull(): ?int
    {
        if ($this->faker->boolean(70)) {
            return null;
        }
        return Comment::inRandomOrder()->first()?->id;
    }
}
