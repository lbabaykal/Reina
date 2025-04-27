<?php

namespace App\Observers\Anime;

use App\Enums\CacheEnum;
use App\Enums\S3Enum;
use App\Enums\StatusEnum;
use App\Models\Anime;
use Illuminate\Support\Facades\Storage;

class AnimeObserver
{
    public function creating(Anime $anime): void
    {
        $anime->slug = str()->slug($anime->title_ru);
    }

    public function created(Anime $anime): void
    {
        if ($anime->status === StatusEnum::PUBLISHED->value) {
            $this->forgetCacheMainAnime();
        }

        $anime->slug = str()->slug($anime->title_ru).'-'.$anime->id;
        $anime->saveQuietly();
    }

    public function updating(Anime $anime): void
    {
        if ($anime->isDirty('poster') && $anime->getOriginal('poster')) {
            Storage::disk(S3Enum::ANIMES->value)->delete($anime->getOriginal('poster'));

            $this->forgetCacheAnime($anime);
            $this->forgetCacheMainAnime();
        }

        if ($anime->isDirty('cover') && $anime->getOriginal('cover')) {
            Storage::disk(S3Enum::ANIMES->value)->delete($anime->getOriginal('cover'));

            $this->forgetCacheAnime($anime);
            $this->forgetCacheMainAnime();
        }

        if ($anime->isDirty('title_ru')) {
            $anime->slug = str()->slug($anime->title_ru).'-'.$anime->id;

            cache()->store(CacheEnum::ANIMES_STORE->value)->forget(CacheEnum::ANIME->value.$anime->getOriginal('id'));
        }
    }

    public function updated(Anime $anime): void
    {
        if (
            $anime->getOriginal('status') === StatusEnum::PUBLISHED->value
            && $anime->status !== StatusEnum::PUBLISHED->value
            || $anime->status === StatusEnum::PUBLISHED->value
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
            Storage::disk(S3Enum::ANIMES->value)->delete($anime->getOriginal('poster'));
        }

        if ($anime->getOriginal('cover') !== null) {
            Storage::disk(S3Enum::ANIMES->value)->delete($anime->getOriginal('cover'));
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
        cache()->store(CacheEnum::ANIMES_STORE->value)->forget(CacheEnum::ANIME->value.$anime->id);
    }
}
