<?php

namespace App\Observers\Dorama;

use App\Models\DoramaFolder;

class DoramaFolderObserver
{
    public function created(DoramaFolder $folder): void
    {
        if ($folder->number === null) {
            $folder->number = $folder->id;
            $folder->saveQuietly();
        }
    }
}
