<?php

namespace App\Observers;

use App\Enums\CacheEnum;
use App\Models\Country;

class CountriesObserver
{
    public function creating(Country $country): void
    {
        $country->slug = str()->slug($country->title_en);
    }

    public function updating(Country $country): void
    {
        if ($country->isDirty('title_en')) {
            $country->slug = str()->slug($country->title_en);
        }
    }

    public function saved(): void
    {
        cache()->store(CacheEnum::DIFFERENT_STORE->value)->forget('countries');
    }

    public function deleted(): void
    {
        cache()->store(CacheEnum::DIFFERENT_STORE->value)->forget('countries');
    }

}
