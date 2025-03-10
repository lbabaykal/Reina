<?php

namespace App\Services;

use App\Models\DoramaFolder;
use Illuminate\Support\Collection;

class DoramaFolderServices
{
    public function foldersUserFor(): Collection
    {
        return DoramaFolder::query()
            ->select(['id', 'title'])
            ->where('user_id', auth()->id())
            ->orWhere('user_id', 0)
            ->orderBy('id')
            ->get();
    }
}
