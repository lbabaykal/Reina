<?php

namespace App\Observers;

use App\Enums\CacheEnum;
use App\Models\PersonRole;

class PersonRoleObserver
{
    public function saved(PersonRole $personRole): void
    {
        cache()->store(CacheEnum::DIFFERENT_STORE->value)->forget($personRole->getTable());
    }

    public function deleted(PersonRole $personRole): void
    {
        cache()->store(CacheEnum::DIFFERENT_STORE->value)->forget($personRole->getTable());
    }
}
