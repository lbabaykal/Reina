<?php

namespace App\Models;

use App\Enums\CacheEnum;
use App\Observers\TypesObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([TypesObserver::class])]
class Type extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'slug',
        'title_ru',
        'title_en',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function animes(): HasMany
    {
        return $this->hasMany(Anime::class);
    }

    public function doramas(): HasMany
    {
        return $this->hasMany(Dorama::class);
    }

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
