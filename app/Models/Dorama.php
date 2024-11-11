<?php

namespace App\Models;

use App\Observers\Dorama\DoramaObserver;
use App\Traits\AnimeAndDoramaTrait;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

#[ObservedBy([DoramaObserver::class])]
class Dorama extends Model
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

    public function favorites(): HasMany
    {
        return $this->hasMany(FavoriteDorama::class);
    }

    public function doramaEpisodes(): HasMany
    {
        return $this->hasMany(DoramaEpisode::class);
    }

    public function getPosterUrlAttribute(): string
    {
        return $this->poster
            ? Storage::disk('s3_doramas')->url($this->poster)
            : Storage::disk('s3_doramas')->url('no_poster.png');
    }

    public function getCoverUrlAttribute(): string
    {
        return $this->cover
            ? Storage::disk('s3_doramas')->url($this->cover)
            : Storage::disk('s3_doramas')->url('no_cover.png');
    }

}
