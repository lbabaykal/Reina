<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnimeRatingStatistic extends Model
{
    protected $fillable = [
        'anime_id',
        'assessment_1',
        'assessment_2',
        'assessment_3',
        'assessment_4',
        'assessment_5',
        'assessment_6',
        'assessment_7',
        'assessment_8',
        'assessment_9',
        'assessment_10',
        'count_assessments',
        'rating',
    ];

    public function anime(): BelongsTo
    {
        return $this->belongsTo(Anime::class);
    }
}
