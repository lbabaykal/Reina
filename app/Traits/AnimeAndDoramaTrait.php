<?php

namespace App\Traits;

use App\Models\Franchise;
use App\Models\Genre;
use App\Models\Scopes\PublishedScope;
use App\Models\Studio;
use App\Models\Type;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

trait AnimeAndDoramaTrait
{
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

    public function franchise(): BelongsTo
    {
        return $this->belongsTo(Franchise::class);
    }

    public function findBySlugId(string $slug, array $columns = ['*'])
    {
        // TODO Проверить мб куда пригодиться
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
            : Storage::disk('s3_'.$table)->url('no_cover.jpg');
    }
}
