<?php

namespace App\Actions;

use App\Enums\CacheEnum;
use App\Models\Anime;
use App\Reina;

class MainAnimesAction
{
    public function execute()
    {
        return cache()->store(CacheEnum::ANIMES_STORE->value)->flexible(CacheEnum::MAIN_ANIMES->value, [1200, 1800], function () {
            return Anime::query()
                ->select(['id', 'slug', 'poster', 'title_ru', 'rating', 'episodes_released', 'episodes_total', 'is_rating'])
                ->limit(Reina::COUNT_ARTICLES_MAIN)
                ->latest('updated_at')
                ->get();
        });
    }
}
