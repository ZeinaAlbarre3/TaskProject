<?php

namespace App\Enums\Media;

enum MediaFolder: string
{
    case USER_MEDIA = 'user';

    case USER_PROFILE = 'user/profile';

    case PODCAST_VIDEO = 'podcast/video';

    case PODCAST_COVER = 'podcast/cover';
}
