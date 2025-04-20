<?php

namespace App\Http\Controllers\User;

use App\Enums\Media\MediaCategory;
use App\Enums\Media\MediaFolder;
use App\Enums\Media\MediaModel;
use App\Enums\Media\MediaType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Media\PodcastRequest;
use App\Http\Requests\Media\UpdatePodcastRequest;
use App\Models\Podcast;
use App\Services\Media\MediaService;
use App\Services\Media\PodcastService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class PodcastController extends Controller
{
    use ResponseTrait;
    private PodcastService $podcastService;
    private MediaService $mediaService;

    public function __construct(PodcastService $podcastService){
        $this->podcastService = $podcastService;
    }

    public function uploadPodcast(PodcastRequest $request): JsonResponse
    {
        $userId = auth()->user()->id;

        $data = $this->podcastService->uploadPodcast($request, $userId);

        return self::success($data['data'],$data['message']);
    }

    public function updatePodcast(UpdatePodcastRequest $request,Podcast $podcast): JsonResponse
    {
        Gate::authorize('update', $podcast);

        $data = $this->podcastService->updatePodcast($request,$podcast);

        return self::success($data['data'],$data['message']);
    }

    public function deletePodcast(Podcast $podcast): JsonResponse
    {
        Gate::authorize('delete', $podcast);

        $data = $this->podcastService->deletePodcast($podcast);

        return self::success([],$data['message']);
    }
}
