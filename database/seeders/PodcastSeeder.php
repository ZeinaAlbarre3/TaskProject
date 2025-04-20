<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Podcast;
use Database\Factories\PodcastMediaFactory;
use Illuminate\Database\Seeder;

class PodcastSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $podcasts = Podcast::factory(20)->create();

        foreach ($podcasts as $podcast) {
            PodcastMediaFactory::new()->cover()->create([
                'mediable_id' => $podcast->id,
                'mediable_type' => Podcast::class
            ]);
            PodcastMediaFactory::new()->video()->create([
                'mediable_id' => $podcast->id,
                'mediable_type' => Podcast::class
            ]);

            $comments = Comment::factory(rand(1, 4))->create([
                'podcast_id' => $podcast['id'],
            ]);
            foreach ($comments as $comment) {
                Comment::factory(rand(1, 4))->create([
                    'podcast_id' => $podcast['id'],
                    'parent_id' => $comment['id']
                ]);
            }
        }
    }
}
