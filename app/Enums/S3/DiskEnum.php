<?php

namespace App\Enums\S3;

enum DiskEnum: string
{
    case ANIMES = 's3_animes';
    case DORAMAS = 's3_doramas';
    case IMAGES = 's3_images';
}
