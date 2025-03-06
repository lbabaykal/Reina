<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FavoriteDorama extends Model
{
    protected $fillable = [
        'user_id',
        'dorama_id',
        'dorama_folder_id',
        'episode',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function doramaFolders(): BelongsTo
    {
        return $this->belongsTo(DoramaFolder::class);
    }
}
