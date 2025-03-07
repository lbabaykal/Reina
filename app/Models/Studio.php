<?php

namespace App\Models;

use App\Observers\StudiosObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

#[ObservedBy([StudiosObserver::class])]
class Studio extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasSlug;

    public $timestamps = false;

    protected $fillable = [
        'slug',
        'title',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['title'])
            ->saveSlugsTo('slug');
    }

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
        return cache()->remember($this->getTable(), 14400, function () {
            return self::query()->orderBy('id')->get();
        });
    }
}
