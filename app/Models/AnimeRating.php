<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnimeRating extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'anime_id',
        'user_id',
        'assessment',
    ];

    public function anime(): BelongsTo
    {
        return $this->belongsTo(Anime::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
