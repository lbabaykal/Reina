<?php

namespace App\Observers;

use App\Models\Studio;

class StudiosObserver
{
    public function creating(Studio $studio): void
    {
        $studio->slug = str()->slug($studio->title);
    }

    public function updating(Studio $studio): void
    {
        if ($studio->isDirty('title')) {
            $studio->slug = str()->slug($studio->title);
        }
    }

    public function saved(): void
    {
        cache()->forget('studios');
    }

    public function deleted(): void
    {
        cache()->forget('studios');
    }
}
