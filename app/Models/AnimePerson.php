<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnimePerson extends Model
{
    protected $table = 'anime_person';

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function anime(): BelongsTo
    {
        return $this->belongsTo(Anime::class);
    }

    public function personRole(): BelongsTo
    {
        return $this->belongsTo(PersonRole::class);
    }
}
