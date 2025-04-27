<?php

namespace App\Models;

use App\Observers\GenresObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([GenresObserver::class])]
class Genre extends Model
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

    public function animes(): BelongsToMany
    {
        return $this->belongsToMany(Anime::class);
    }

    public function doramas(): BelongsToMany
    {
        return $this->belongsToMany(Dorama::class);
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
