<?php

namespace App\Actions\Anime;

use App\Enums\CacheEnum;
use App\Events\AnimeViewedEvent;

class RecordAnimeViewAction
{
    public static function execute(int $animeId): void
    {
        $ipAddress = request()->ip();
        $userAgent = request()->userAgent();

        $cacheKey = "anime_{$animeId}_viewed_{$ipAddress}";

        if (! cache()->store(CacheEnum::DIFFERENT_STORE->value)->has($cacheKey)) {
            cache()->store(CacheEnum::DIFFERENT_STORE->value)->put($cacheKey, true, now()->addHour());

            event(new AnimeViewedEvent($animeId, $ipAddress, $userAgent));
        }
    }
}
