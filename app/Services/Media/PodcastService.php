<?php

namespace App\Services\Media;

use App\Enums\Media\MediaCategory;
use App\Enums\Media\MediaFolder;
use App\Enums\Media\MediaModel;
use App\Enums\Media\MediaType;
use App\Models\Podcast;
use Illuminate\Http\UploadedFile;

class PodcastService extends MediaService
{
    public function createPodcast($request,$userId)
    {
        return Podcast::query()->create([
            'title'=>$request['title'] ,
            'description'=>$request['description'],
            'user_id'=>$userId,
        ]);
    }
    public function uploadPodcast($request,$userId): array
    {
        $podcast = $this->createPodcast($request, $userId);

        $video = $this->uploadPodcastVideo($request->file('video'), $podcast);

        if ($request->hasFile('image')) {
            $cover = $this->uploadPodcastCover($request->file('image'), $podcast);
        }

        return [
            'data' => [
                'podcast' => $podcast,
                'video' => $video,
                'cover' => $cover ?? null,
            ],
            'message' => 'Podcast uploaded successfully.',
            'code' => 200,
        ];
    }
    public function uploadPodcastVideo(UploadedFile $video, Podcast $podcast): array
    {
        return $this->uploadFile(
            $video,
            $podcast['id'],
            MediaModel::PODCAST_MEDIA->value,
            MediaType::VIDEO->value,
            MediaCategory::PODCAST_VIDEO->value,
            MediaFolder::PODCAST_VIDEO->value
        );
    }
    public function uploadPodcastCover(UploadedFile $image, Podcast $podcast): array
    {
        return $this->uploadFile(
            $image,
            $podcast['id'],
            MediaModel::PODCAST_MEDIA->value,
            MediaType::IMAGE->value,
            MediaCategory::PODCAST_COVER->value,
            MediaFolder::PODCAST_COVER->value
        );
    }
    public function updatePodcast($request, Podcast $podcast): array
    {
        $this->updatePodcastData($request, $podcast);

        if ($request->hasFile('image')) {
            $this->updatePodcastCover($request, $podcast);
        }

        if ($request->hasFile('video')) {
            $this->updatePodcastVideo($request, $podcast);
        }

        return [
            'data' => $podcast->refresh()->load('media'),
            'message' => 'Podcast updated successfully.',
            'code' => 200,
        ];
    }
    private function updatePodcastData($request, Podcast $podcast): void
    {
        $podcast->update($request->only('title', 'description'));
    }
    private function updatePodcastVideo($request, Podcast $podcast): void
    {
        $video = $podcast->media()
            ->where('category', MediaCategory::PODCAST_VIDEO->value)
            ->firstOrFail();

        $this->updateFile($video, $request->file('video'), MediaFolder::PODCAST_VIDEO->value);
    }
    private function updatePodcastCover($request, Podcast $podcast): void
    {
        $cover = $podcast->media()
            ->where('category', MediaCategory::PODCAST_COVER->value)
            ->first();

        if(!$cover){
            $this->uploadPodcastCover($request->file('image'), $podcast);
        }
        else {
            $this->updateFile($cover, $request->file('image'), MediaFolder::PODCAST_COVER->value);
        }
    }
    public function deletePodcast(Podcast $podcast): array
    {
        foreach ($podcast->media as $media) {
            $this->deleteFile($media);
        }

        $podcast->delete();

        return [
            'data' => [],
            'message' => 'Podcast deleted successfully.',
            'code' => 200,
        ];
    }
}
