<?php

namespace App\Traits;

use App\Models\Country;
use App\Models\Genre;
use App\Models\Rating;
use App\Models\Scopes\PublishedScope;
use App\Models\Studio;
use App\Models\Type;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

trait AnimeAndDoramaTrait
{

    use HasSlug;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new PublishedScope());
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function studios(): BelongsToMany
    {
        return $this->belongsToMany(Studio::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    public function ratings(): MorphMany
    {
        return $this->morphMany(Rating::class, 'ratingable');
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom(['id', 'title_ru'])
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnCreate();
    }

    public function findBySlugId(string $slug, array $columns = ['*'])
    {
        preg_match('/^\d+/', $slug, $matches);

        if (empty($matches[0])) {
            return null;
        }

        $model = static::query()->where('id', $matches[0])->first($columns);

        if (is_null($model)) {
            abort(404); //TODO
        }

        return $model;
    }
}
