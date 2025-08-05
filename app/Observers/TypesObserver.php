<?php

namespace App\Observers;

use App\Enums\CacheEnum;
use App\Models\Type;

class TypesObserver
{
    public function creating(Type $type): void
    {
        $type->slug = str()->slug($type->title_en);
    }

    public function updating(Type $type): void
    {
        if ($type->isDirty('title_en')) {
            $type->slug = str()->slug($type->title_en);
        }
    }

    public function saved(): void
    {
        cache()->store(CacheEnum::DIFFERENT_STORE->value)->forget('types');
    }

    public function deleted(): void
    {
        cache()->store(CacheEnum::DIFFERENT_STORE->value)->forget('types');
    }
}
