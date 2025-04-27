<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoramaRating extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'dorama_id',
        'user_id',
        'assessment',
    ];

    protected $casts = [
        'assessment' => 'integer',
    ];

    public function dorama(): BelongsTo
    {
        return $this->belongsTo(Dorama::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
