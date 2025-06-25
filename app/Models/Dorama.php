<?php

namespace App\Models;

use App\Enums\AgeRatingEnum;
use App\Enums\S3\DiskEnum;
use App\Enums\StatusEnum;
use App\Observers\Dorama\DoramaObserver;
use App\Traits\AnimeAndDoramaTrait;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

#[ObservedBy([DoramaObserver::class])]
class Dorama extends Model
{
    use AnimeAndDoramaTrait;
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'slug',
        'poster',
        'cover',
        'title_org',
        'title_ru',
        'title_en',
        'type_id',
        'genre_id',
        'studio_id',
        'country_id',
        'franchise_id',
        'age_rating',
        'episodes_released',
        'episodes_total',
        'duration',
        'release',
        'description',
        'status',
        'rating',
        'count_assessments',
        'views',
        'is_comment',
        'is_rating',
    ];

    protected $casts = [
        'age_rating' => AgeRatingEnum::class,
        'episodes_released' => 'integer',
        'episodes_total' => 'integer',
        'duration' => 'integer',
        'release' => 'date',
        'description' => 'string',
        'status' => StatusEnum::class,
        'rating' => 'float',
        'count_assessments' => 'integer',
        'views' => 'integer',
        'is_comment' => 'boolean',
        'is_rating' => 'boolean',
    ];

    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class, 'dorama_country');
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(DoramaRating::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(FavoriteDorama::class);
    }

    public function episodes(): HasMany
    {
        return $this->hasMany(DoramaEpisode::class);
    }

    public function persons(): HasMany
    {
        return $this->hasMany(DoramaPerson::class);
    }

    public function ratingStatistic(): HasOne
    {
        return $this->hasOne(AnimeRatingStatistic::class);
    }

    public function getPosterUrlAttribute(): ?string
    {
        return $this->poster
            ? Storage::disk(DiskEnum::DORAMAS->value)->url($this->poster)
            : null;
    }

    public function getCoverUrlAttribute(): ?string
    {
        return $this->cover
            ? Storage::disk(DiskEnum::DORAMAS->value)->url($this->cover)
            : null;
    }
}
