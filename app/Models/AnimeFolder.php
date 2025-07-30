<?php

namespace App\Models;

use App\Observers\Anime\AnimeFolderObserver;
use App\Policies\Folders\AnimeFolderPolicy;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[UsePolicy(AnimeFolderPolicy::class)]
#[ObservedBy([AnimeFolderObserver::class])]
class AnimeFolder extends Model
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

    public function favoritesAnimesUser(): HasMany
    {
        return $this->hasMany(FavoriteAnime::class)->where('user_id', auth()->id());
    }
}
