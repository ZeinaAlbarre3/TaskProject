<?php

namespace App\Services\Media;

use App\Exceptions\Types\CustomException;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    public function uploadImage(Request $request,$model,$id) {

        $folder = strtolower(class_basename($model));

        $filename = Str::random(32) . "." . time() . '.' . $request->file('image')->getClientOriginalExtension();
        $imagePath = $folder . '/' . $filename;

        Storage::disk('public')->put($imagePath, file_get_contents($request->file('image')));

        $media = Media::create([
            'mediable_id' => $id,
            'mediable_type' => $model,
            'url' => $imagePath,
        ]);

        return ['data' => $media,'message' => 'Image Created Successfully.','code' => 200];
    }

    public function uploadMultipleImages(Request $request, $model, $id)
    {
        $images = [];

        foreach ($request->file('images') as $image) {
            $imageRequest = new Request(['image' => $image]);
            $imageRequest->files->set('image', $image);
            $images[] = $this->uploadImage($imageRequest, $model, $id);
        }

        return ['data' => $images, 'message' => 'Images uploaded successfully.', 'code' => 200];
    }

    public function deleteImage($mediaId,$model) {

        $media = Media::where('mediable_id',$mediaId)
            ->where('mediable_type',$model)
            ->first();

        if (!$media || !$media->url)  throw new CustomException('Image not found.',404);

        Storage::disk('public')->delete($media->url);

        $media->delete();

        return ['data' => [],'message' => 'Image Deleted Successfully.','code' => 200];
    }
}
