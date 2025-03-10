<?php

namespace App\Services;

use App\Models\AnimeFolder;
use Illuminate\Support\Collection;

class AnimeFolderServices
{
    public function foldersUserFor(): Collection
    {
        return AnimeFolder::query()
            ->select(['id', 'title'])
            ->where('user_id', auth()->id())
            ->orWhere('user_id', 0)
            ->orderBy('id')
            ->get();
    }
}
