<?php

namespace App\Enums\S3;

enum FolderEnum: string
{
    case IMAGES = 'images';
    case POSTERS = 'posters';
    case COVERS = 'covers';
    case AVATARS = 'avatars';
    case CHARACTERS = 'characters';
    case PERSONS = 'persons';
}
