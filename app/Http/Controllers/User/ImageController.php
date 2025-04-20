<?php

namespace App\Http\Controllers\User;

use App\Enums\Media\MediaCategory;
use App\Enums\Media\MediaModel;
use App\Enums\Media\MediaFolder;
use App\Enums\Media\MediaType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Media\MultipleImageRequest;
use App\Http\Requests\Media\SingleImageRequest;
use App\Models\Media;
use App\Services\Media\UserImageService;
use App\Services\Media\MediaService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class ImageController extends Controller
{
    use ResponseTrait;
    private MediaService $mediaService;
    private UserImageService  $imageService;

    public function __construct(UserImageService $imageService){
        $this->imageService = $imageService;
    }

    public function uploadImage(SingleImageRequest $request): JsonResponse
    {
        $userId = auth()->user()->id;

        $data = $this->imageService->uploadUserImage($request->file('image'), $userId);

        return self::success($data['data'],$data['message']);
    }

    public function uploadMultipleImages(MultipleImageRequest $request): JsonResponse
    {
        $userId = auth()->user()->id;

        $data = $this->imageService->uploadMultipleUserImages($request->file('images'), $userId);

        return self::success($data['data'],$data['message']);
    }

    public function deleteImage(Media $media): JsonResponse
    {
        $data = $this->imageService->deleteUserImage($media);

        return self::success($data['data'],$data['message']);
    }

}
