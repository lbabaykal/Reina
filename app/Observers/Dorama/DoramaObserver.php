<?php

namespace App\Observers\Dorama;

use App\Enums\CacheEnum;
use App\Enums\StatusEnum;
use App\Models\Dorama;
use App\Services\Image\CoverService;
use App\Services\Image\PosterService;

class DoramaObserver
{
    public function creating(Dorama $dorama): void
    {
        $dorama->slug = str()->slug($dorama->title_ru);
    }

    public function created(Dorama $dorama): void
    {
        $dorama->slug = str()->slug($dorama->title_ru) . '-' . $dorama->id;
        $dorama->saveQuietly();

        if ($dorama->status === StatusEnum::PUBLISHED->value) {
            $this->forgetCacheMainDorama();
        }
    }

    public function updating(Dorama $dorama): void
    {
        if ($dorama->isDirty('poster') && $dorama->getOriginal('poster')) {
            new PosterService()->deleteForDorama($dorama->getOriginal('poster'));
        }

        if ($dorama->isDirty('cover') && $dorama->getOriginal('cover')) {
            new CoverService()->deleteForDorama($dorama->getOriginal('cover'));
        }

        if ($dorama->isDirty('title_ru')) {
            $dorama->slug = str()->slug($dorama->title_ru) . '-' . $dorama->id;
        }
    }

    public function updated(Dorama $dorama): void
    {
        if (
            $dorama->getOriginal('status') === StatusEnum::PUBLISHED
            && $dorama->status !== StatusEnum::PUBLISHED
            || $dorama->status === StatusEnum::PUBLISHED
        ) {
            $this->forgetCacheDorama($dorama);
            $this->forgetCacheMainDorama();
        }
    }

    public function saving(Dorama $dorama): void
    {
        //
    }

    public function saved(Dorama $dorama): void
    {
        //
    }

    public function deleted(Dorama $dorama): void
    {
        $this->forgetCacheDorama($dorama);
        $this->forgetCacheMainDorama();
    }

    public function restored(Dorama $dorama): void
    {
        //
    }

    public function forceDeleted(Dorama $dorama): void
    {
        $dorama->genres()->detach();
        $dorama->studios()->detach();

        $dorama->ratings()->delete();
        $dorama->favorites()->delete();

        $dorama->episodes()->delete();

        if ($dorama->getOriginal('poster') !== null) {
            new PosterService()->deleteForDorama($dorama->getOriginal('poster'));
        }

        if ($dorama->getOriginal('cover') !== null) {
            new CoverService()->deleteForDorama($dorama->getOriginal('cover'));
        }

        $this->forgetCacheDorama($dorama);
        $this->forgetCacheMainDorama();
    }

    public function retrieved(Dorama $dorama): void
    {
        //
    }

    public function forgetCacheMainDorama(): void
    {
        cache()->store(CacheEnum::DORAMAS_STORE->value)->forget(CacheEnum::MAIN_DORAMAS->value);
    }

    public function forgetCacheDorama(Dorama $dorama): void
    {
        cache()->store(CacheEnum::DORAMAS_STORE->value)->forget(CacheEnum::DORAMA->value . $dorama->id);
    }
}
