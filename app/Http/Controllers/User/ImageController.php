<?php

namespace App\Http\Controllers\User;

use App\Enums\Media\MediaModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\Media\MultipleImageRequest;
use App\Http\Requests\Media\SingleImageRequest;
use App\Services\Media\ImageService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    use ResponseTrait;
    private ImageService $imageService;

    public function __construct(ImageService $imageService){
        $this->imageService = $imageService;
    }

    public function uploadImage(SingleImageRequest $request)
    {
        $user = auth()->user()->id;

        $data = $this->imageService->uploadImage($request, MediaModel::USER_MEDIA->value, $user);

        return self::success($data['data'],$data['message']);
    }

    public function uploadMultipleImages(MultipleImageRequest $request)
    {
        $user = auth()->user()->id;

        $data = $this->imageService->uploadMultipleImages($request, MediaModel::USER_MEDIA->value,$user);

        return self::success($data['data'],$data['message']);

    }

    public function deleteImage($imageId)
    {
        $data = $this->imageService->deleteImage($imageId,MediaModel::USER_MEDIA->value);

        return self::success($data['data'],$data['message']);
    }

}
