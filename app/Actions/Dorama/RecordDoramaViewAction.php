<?php

namespace App\Actions\Dorama;

use App\Enums\CacheEnum;
use App\Events\DoramaViewedEvent;

class RecordDoramaViewAction
{
    public static function execute(int $doramaId): void
    {
        $ipAddress = request()->ip();
        $userAgent = request()->userAgent();

        $cacheKey = "dorama_{$doramaId}_viewed_{$ipAddress}";

        if (! cache()->store(CacheEnum::VIEWS_STORE->value)->has($cacheKey)) {
            cache()->store(CacheEnum::VIEWS_STORE->value)->put($cacheKey, true, now()->addHour());

            event(new DoramaViewedEvent($doramaId, $ipAddress, $userAgent));
        }
    }
}
