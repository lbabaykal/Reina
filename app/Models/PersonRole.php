<?php

namespace App\Models;

use App\Enums\CacheEnum;
use App\Observers\PersonRoleObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([PersonRoleObserver::class])]
class PersonRole extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'slug',
        'name',
    ];

    public function cache(): Collection
    {
        if (cache()->store(CacheEnum::DIFFERENT_STORE->value)->has($this->getTable())) {
            return cache()->store(CacheEnum::DIFFERENT_STORE->value)->get($this->getTable());
        }

        return cache()->store(CacheEnum::DIFFERENT_STORE->value)->rememberForever($this->getTable(), function () {
            return self::query()->orderBy('id')->get();
        });
    }
}
