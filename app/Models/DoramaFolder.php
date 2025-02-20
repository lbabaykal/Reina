<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DoramaFolder extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'user_id',
        'is_private',
        'number',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function favoritesDoramasUser(): HasMany
    {
        return $this->hasMany(FavoriteDorama::class)->where('user_id', auth()->id());
    }
}
