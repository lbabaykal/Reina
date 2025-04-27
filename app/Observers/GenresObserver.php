<?php

namespace App\Observers;

use App\Models\Genre;

class GenresObserver
{
    public function creating(Genre $genre): void
    {
        $genre->slug = str()->slug($genre->title_en);
    }

    public function updating(Genre $genre): void
    {
        if ($genre->isDirty('title_en')) {
            $genre->slug = str()->slug($genre->title_en);
        }
    }

    public function saved(): void
    {
        cache()->forget('genres');
    }

    public function deleted(): void
    {
        cache()->forget('genres');
    }

}
