<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoramaPerson extends Model
{
    protected $table = 'dorama_person';

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function dorama(): BelongsTo
    {
        return $this->belongsTo(Dorama::class);
    }

    public function personRole(): BelongsTo
    {
        return $this->belongsTo(PersonRole::class);
    }
}
