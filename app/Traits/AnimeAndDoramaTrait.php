<?php

namespace App\Traits;

use App\Models\Franchise;
use App\Models\Genre;
use App\Models\Scopes\PublishedScope;
use App\Models\Studio;
use App\Models\Type;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait AnimeAndDoramaTrait
{
    protected static function boot(): void
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
}
