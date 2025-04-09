<?php

namespace App\Observers\Dorama;

use App\Enums\CacheEnum;
use App\Enums\StatusEnum;
use App\Models\Dorama;
use App\Models\DoramaEpisode;
use Illuminate\Support\Facades\Cache;

class DoramaEpisodeObserver
{
    public function created(DoramaEpisode $doramaEpisode): void
    {
        if ($doramaEpisode->status === StatusEnum::PUBLISHED->value) {
            $this->updateFieldAndForgetCache($doramaEpisode);
        }
    }

    public function updating(DoramaEpisode $doramaEpisode): void
    {
        //
    }

    public function updated(DoramaEpisode $doramaEpisode): void
    {
        if ($doramaEpisode->isDirty('status')
            && ($doramaEpisode->getOriginal('status') === StatusEnum::PUBLISHED->value
                || $doramaEpisode->getAttribute('status') === StatusEnum::PUBLISHED->value)
        ) {
            $this->updateFieldAndForgetCache($doramaEpisode);
        }
    }

    public function saving(DoramaEpisode $doramaEpisode): void
    {
        //
    }

    public function saved(DoramaEpisode $doramaEpisode): void
    {
        //
    }

    public function deleted(DoramaEpisode $doramaEpisode): void
    {
        if ($doramaEpisode->status === StatusEnum::PUBLISHED->value) {
            $this->updateFieldAndForgetCache($doramaEpisode);
        }
    }

    public function updateFieldAndForgetCache(DoramaEpisode $doramaEpisode): void
    {
        $this->updateDoramaFieldEpisodesReleased($doramaEpisode);
        $this->forgetCacheMainDorama();
        $this->forgetCacheDorama($doramaEpisode);
    }

    public function updateDoramaFieldEpisodesReleased(DoramaEpisode $doramaEpisode): void
    {
        $doramaEpisode->dorama()->update([
            'episodes_released' => Dorama::query()
                ->find($doramaEpisode->dorama->id)
                ->episodes()
                ->where('status', StatusEnum::PUBLISHED)
                ->count(),
            'updated_at' => now(),
        ]);
    }

    public function forgetCacheMainDorama(): void
    {
        cache()->store(CacheEnum::DORAMAS_STORE->value)->forget(CacheEnum::MAIN_DORAMAS->value);
    }

    public function forgetCacheDorama(DoramaEpisode $doramaEpisode): void
    {
        cache()->store(CacheEnum::DORAMAS_STORE->value)->forget(CacheEnum::DORAMA->value.$doramaEpisode->dorama->slug);
    }
}
