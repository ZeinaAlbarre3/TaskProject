<?php

namespace App\Enums\Media;

enum MediaCategory: string
{
    case USER = 'user';

    case USER_PROFILE = 'profile';

    case PODCAST_VIDEO = 'podcast_video';

    case PODCAST_COVER = 'podcast_cover';

}
