<?php

namespace App\Observers\Anime;

use App\Enums\CacheEnum;
use App\Enums\StatusEnum;
use App\Models\Anime;
use App\Models\AnimeEpisode;
use Illuminate\Support\Facades\Cache;

class AnimeEpisodeObserver
{
    public function created(AnimeEpisode $animeEpisode): void
    {
        if ($animeEpisode->status === StatusEnum::PUBLISHED->value) {
            $this->updateFieldAndForgetCache($animeEpisode);
        }
    }

    public function updating(AnimeEpisode $animeEpisode): void
    {
        //
    }

    public function updated(AnimeEpisode $animeEpisode): void
    {
        if ($animeEpisode->isDirty('status')
            && ($animeEpisode->getOriginal('status') === StatusEnum::PUBLISHED->value
                || $animeEpisode->getAttribute('status') === StatusEnum::PUBLISHED->value)
        ) {
            $this->updateFieldAndForgetCache($animeEpisode);
        }
    }

    public function saving(AnimeEpisode $animeEpisode): void
    {
        //
    }

    public function saved(AnimeEpisode $animeEpisode): void
    {
        //
    }

    public function deleted(AnimeEpisode $animeEpisode): void
    {
        if ($animeEpisode->status === StatusEnum::PUBLISHED->value) {
            $this->updateFieldAndForgetCache($animeEpisode);
        }
    }

    public function updateFieldAndForgetCache(AnimeEpisode $animeEpisode): void
    {
        $this->updateAnimeFieldEpisodesReleased($animeEpisode);
        $this->forgetCacheMainAnime();
        $this->forgetCacheAnime($animeEpisode);
    }

    public function updateAnimeFieldEpisodesReleased(AnimeEpisode $animeEpisode): void
    {
        $animeEpisode->anime()->update([
            'episodes_released' => Anime::query()
                ->find($animeEpisode->anime->id)
                ->episodes()
                ->where('status', StatusEnum::PUBLISHED)
                ->count(),
            'updated_at' => now(),
        ]);
    }

    public function forgetCacheMainAnime(): void
    {
        cache()->store(CacheEnum::ANIMES_STORE->value)->forget(CacheEnum::MAIN_ANIMES->value);
    }

    public function forgetCacheAnime(AnimeEpisode $animeEpisode): void
    {
        cache()->store(CacheEnum::ANIMES_STORE->value)->forget(CacheEnum::ANIME->value.$animeEpisode->anime->slug);
    }
}
