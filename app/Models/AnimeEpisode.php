<?php

namespace App\Models;

use App\Enums\StatusEnum;
use App\Observers\Anime\AnimeEpisodeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([AnimeEpisodeObserver::class])]
class AnimeEpisode extends Model
{
    use HasFactory;

    protected $fillable = [
        'anime_id',
        'name_org',
        'name_ru',
        'name_en',
        'status',
        'note',
        'release_date',
    ];

    protected $casts = [
        'release_date' => 'date',
        'note' => 'string',
        'status' => StatusEnum::class,
    ];

    public function teamAnimeEpisodes(): HasMany
    {
        return $this->hasMany(TeamAnimeEpisode::class);
    }
}
