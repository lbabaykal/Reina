<?php

namespace App\Models;

use App\Observers\CountriesObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

#[ObservedBy([CountriesObserver::class])]
class Country extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasSlug;

    public $timestamps = false;

    protected $fillable = [
        'slug',
        'title_ru',
        'title_en',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['title_en'])
            ->saveSlugsTo('slug');
    }

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
        return cache()->remember($this->getTable(), 14400, function () {
            return self::query()->orderBy('id')->get();
        });
    }
}
