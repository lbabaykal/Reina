<?php

namespace App\Models;

use App\Observers\Dorama\DoramaFolderObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([DoramaFolderObserver::class])]
class DoramaFolder extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'is_private',
        'number',
    ];

    protected $casts = [
        'is_private' => 'boolean',
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
