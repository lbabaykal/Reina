<?php

namespace App\Actions;

use App\Enums\CacheEnum;
use App\Models\Dorama;
use App\Reina;

class MainDoramasAction
{
    public function execute()
    {
        return cache()->store(CacheEnum::DORAMAS_STORE->value)->flexible(CacheEnum::MAIN_DORAMAS->value, [1200, 1800], function () {
            return Dorama::query()
                ->select(['id', 'slug', 'poster', 'title_ru', 'rating', 'episodes_released', 'episodes_total', 'is_rating'])
                ->limit(Reina::COUNT_ARTICLES_MAIN)
                ->latest('updated_at')
                ->get();
        });

    }
}
