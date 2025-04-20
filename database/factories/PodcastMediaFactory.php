<?php

namespace Database\Factories;

use App\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class PodcastMediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Media::class;

    public function definition(): array
    {
        return [
            //
        ];
    }

    public function cover(): Factory
    {
        return $this->state([
            'type' => 'image',
            'category' => 'podcast_cover',
            'url' => 'podcast/cover/' . $this->faker->uuid . '.jpg',
        ]);
    }

    public function video(): Factory
    {
        return $this->state([
            'type' => 'video',
            'category' => 'podcast_video',
            'url' => 'podcast/video/' . $this->faker->uuid . '.mp4',
        ]);
    }
}
