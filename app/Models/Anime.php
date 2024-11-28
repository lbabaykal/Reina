<?php

namespace App\Models;

use App\Observers\Anime\AnimeObserver;
use App\Traits\AnimeAndDoramaTrait;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

#[ObservedBy([AnimeObserver::class])]
class Anime extends Model
{
    use HasFactory;
    use SoftDeletes;
    use AnimeAndDoramaTrait;

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
        'age_rating',
        'episodes_released',
        'episodes_total',
        'duration',
        'release',
        'description',
        'status',
        'rating',
        'count_assessments',
        'is_comment',
        'is_rating',
    ];

    public $timestamps = true;

    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(FavoriteAnime::class);
    }

    public function animeEpisodes(): HasMany
    {
        return $this->hasMany(AnimeEpisode::class);
    }

    public function getPosterUrlAttribute(): string
    {
        return $this->poster
            ? Storage::disk('s3_animes')->url($this->poster)
            : Storage::disk('s3_animes')->url('no_poster.png');
    }

    public function getCoverUrlAttribute(): string
    {
        return $this->cover
            ? Storage::disk('s3_animes')->url($this->cover)
            : Storage::disk('s3_animes')->url('no_cover.png');
    }

}
