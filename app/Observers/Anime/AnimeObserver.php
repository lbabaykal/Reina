<?php

namespace App\Observers\Anime;

use App\Enums\CacheEnum;
use App\Enums\StatusEnum;
use App\Models\Anime;
use App\Services\Image\CoverService;
use App\Services\Image\PosterService;

class AnimeObserver
{
    public function creating(Anime $anime): void
    {
        $anime->slug = str()->slug($anime->title_ru);
    }

    public function created(Anime $anime): void
    {
        $anime->slug = str()->slug($anime->title_ru) . '-' . $anime->id;
        $anime->saveQuietly();

        if ($anime->status === StatusEnum::PUBLISHED) {
            $this->forgetCacheMainAnime();
        }
    }

    public function updating(Anime $anime): void
    {
        if ($anime->isDirty('poster') && $anime->getOriginal('poster')) {
            new PosterService()->deleteForAnime($anime->getOriginal('poster'));
        }

        if ($anime->isDirty('cover') && $anime->getOriginal('cover')) {
            new CoverService()->deleteForAnime($anime->getOriginal('cover'));
        }

        if ($anime->isDirty('title_ru')) {
            $anime->slug = str()->slug($anime->title_ru) . '-' . $anime->id;
        }
    }

    public function updated(Anime $anime): void
    {
        if (
            $anime->getOriginal('status') === StatusEnum::PUBLISHED
            && $anime->status !== StatusEnum::PUBLISHED
            || $anime->status === StatusEnum::PUBLISHED
        ) {
            $this->forgetCacheAnime($anime);
            $this->forgetCacheMainAnime();
        }
    }

    public function saving(Anime $anime): void
    {
        //
    }

    public function saved(Anime $anime): void
    {
        //
    }

    public function deleted(Anime $anime): void
    {
        $this->forgetCacheAnime($anime);
        $this->forgetCacheMainAnime();
    }

    public function restored(Anime $anime): void
    {
        //
    }

    public function forceDeleted(Anime $anime): void
    {
        $anime->genres()->detach();
        $anime->studios()->detach();

        $anime->ratings()->delete();
        $anime->favorites()->delete();

        $anime->episodes()->delete();

        if ($anime->getOriginal('poster') !== null) {
            new PosterService()->deleteForAnime($anime->getOriginal('poster'));
        }

        if ($anime->getOriginal('cover') !== null) {
            new CoverService()->deleteForAnime($anime->getOriginal('cover'));
        }

        $this->forgetCacheAnime($anime);
        $this->forgetCacheMainAnime();
    }

    public function retrieved(Anime $anime): void
    {
        //
    }

    public function forgetCacheMainAnime(): void
    {
        cache()->store(CacheEnum::ANIMES_STORE->value)->forget(CacheEnum::MAIN_ANIMES->value);
    }

    public function forgetCacheAnime(Anime $anime): void
    {
        cache()->store(CacheEnum::ANIMES_STORE->value)->forget(CacheEnum::ANIME->value . $anime->id);
    }
}
