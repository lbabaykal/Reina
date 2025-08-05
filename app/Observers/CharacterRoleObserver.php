<?php

namespace App\Observers;

use App\Enums\CacheEnum;
use App\Models\CharacterRole;

class CharacterRoleObserver
{
    public function saved(CharacterRole $characterRole): void
    {
        cache()->store(CacheEnum::DIFFERENT_STORE->value)->forget($characterRole->getTable());
    }

    public function deleted(CharacterRole $characterRole): void
    {
        cache()->store(CacheEnum::DIFFERENT_STORE->value)->forget($characterRole->getTable());
    }
}
