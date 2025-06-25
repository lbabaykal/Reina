<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnimeCharacter extends Model
{
    protected $table = 'anime_character';

    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }

    public function anime(): BelongsTo
    {
        return $this->belongsTo(Anime::class);
    }

    public function characterRole(): BelongsTo
    {
        return $this->belongsTo(CharacterRole::class);
    }

}
