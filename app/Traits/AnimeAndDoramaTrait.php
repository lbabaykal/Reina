<?php

namespace App\Traits;

use App\Models\Franchise;
use App\Models\Genre;
use App\Models\Scopes\PublishedScope;
use App\Models\Studio;
use App\Models\Type;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Storage;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

trait AnimeAndDoramaTrait
{
    use HasSlug;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new PublishedScope);
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

    public function franchise(): MorphToMany
    {
        return $this->morphToMany(Franchise::class, 'franchiseable');
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

        return static::query()->where('id', $matches[0])->firstOrFail($columns);
    }

    public function getPosterUrlAttribute(): string
    {
        $table = $this->getTable();

        return $this->poster
            ? Storage::disk('s3_'.$table)->url($this->poster)
            : Storage::disk('s3_'.$table)->url('no_poster.png');
    }

    public function getCoverUrlAttribute(): string
    {
        $table = $this->getTable();

        return $this->cover
            ? Storage::disk('s3_'.$table)->url($this->cover)
            : Storage::disk('s3_'.$table)->url('no_cover.png');
    }
}
