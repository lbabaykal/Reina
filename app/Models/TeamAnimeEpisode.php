<?php

namespace App\Models;

use App\Enums\StatusEnum;
use App\Enums\TypesEpisodeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamAnimeEpisode extends Model
{
    protected $fillable = [
        'anime_episode_id',
        'team_id',
        'type',
        'link',
        'note',
        'status',
    ];

    protected $casts = [
        'type' => TypesEpisodeEnum::class,
        'status' => StatusEnum::class,
    ];

    public function episode(): BelongsTo
    {
        return $this->belongsTo(AnimeEpisode::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
