<?php

namespace App\Observers;

use App\Enums\CacheEnum;
use App\Models\Anime;
use App\Models\Dorama;
use App\Models\Franchise;

class FranchisesObserver
{
    public function creating(Franchise $franchise): void
    {
        $franchise->slug = str()->slug($franchise->title_ru);
    }

    public function updating(Franchise $franchise): void
    {
        if ($franchise->isDirty('title_ru')) {
            $franchise->slug = str()->slug($franchise->title_ru);
        }
    }

    public function saved(Franchise $franchise): void
    {
        cache()->store(CacheEnum::DIFFERENT_STORE->value)->forget(CacheEnum::FRANCHISE->value.$franchise->id);
    }

    public function deleting(Franchise $franchise): void
    {

        $animes = Anime::query()->select(['id', 'franchise_id'])->where('franchise_id', $franchise->id)->get();
        Anime::withoutTimestamps(function () use ($animes) {
            Anime::withoutEvents(function () use ($animes) {
                foreach ($animes as $anime) {
                    $anime->franchise_id = null;
                    $anime->save();

                    cache()->store(CacheEnum::ANIMES_STORE->value)->forget(CacheEnum::ANIME->value.$anime->id);
                }
            });
        });

        $doramas = Dorama::query()->select(['id', 'franchise_id'])->where('franchise_id', $franchise->id)->get();
        Dorama::withoutTimestamps(function () use ($doramas) {
            Dorama::withoutEvents(function () use ($doramas) {
                foreach ($doramas as $dorama) {
                    $dorama->franchise_id = null;
                    $dorama->save();

                    cache()->store(CacheEnum::DORAMAS_STORE->value)->forget(CacheEnum::DORAMA->value.$dorama->id);
                }
            });
        });
    }

    public function deleted(Franchise $franchise): void
    {
        cache()->store(CacheEnum::DIFFERENT_STORE->value)->forget(CacheEnum::FRANCHISE->value.$franchise->id);
    }
}
