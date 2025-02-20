<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FavoriteAnime extends Model
{
    protected $fillable = [
        'user_id',
        'anime_id',
        'anime_folder_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function animeFolders(): BelongsTo
    {
        return $this->belongsTo(AnimeFolder::class);
    }
}
