<?php

namespace App\Models;

use App\Observers\CountriesObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([CountriesObserver::class])]
class Country extends Model
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
        if (cache()->has($this->getTable())) {
            return cache()->get($this->getTable());
        }

        return cache()->rememberForever($this->getTable(), function () {
            return self::query()->orderBy('id')->get();
        });
    }
}
