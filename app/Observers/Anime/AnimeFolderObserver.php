<?php

namespace App\Observers\Anime;

use App\Models\AnimeFolder;

class AnimeFolderObserver
{
    public function created(AnimeFolder $folder): void
    {
        if ($folder->number === null) {
            $folder->number = $folder->id;
            $folder->saveQuietly();
        }
    }
}
