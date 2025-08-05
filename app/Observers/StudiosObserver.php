<?php

namespace App\Observers;

use App\Enums\CacheEnum;
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
        cache()->store(CacheEnum::DIFFERENT_STORE->value)->forget('studios');
    }

    public function deleted(): void
    {
        cache()->store(CacheEnum::DIFFERENT_STORE->value)->forget('studios');
    }
}
