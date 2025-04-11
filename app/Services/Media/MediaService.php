<?php

namespace App\Services\Media;

use App\Exceptions\Types\CustomException;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaService
{
   public function createMedia($id,$type,$url){
       return Media::query()->create([
           'mediable_id' => $id,
           'mediable_type' => $type,
           'url' => $url,
       ]);
   }
}
