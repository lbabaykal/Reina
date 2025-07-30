<?php

namespace App\Models;

use App\Observers\UserObserver;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'avatar',
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function animeRating(): HasMany
    {
        return $this->hasMany(AnimeRating::class);
    }

    public function doramaRating(): HasMany
    {
        return $this->hasMany(DoramaRating::class);
    }

    public function animeFolders(): HasMany
    {
        return $this->hasMany(AnimeFolder::class);
    }

    public function animeFoldersWithDefault(): HasMany
    {
        return $this->hasMany(AnimeFolder::class)->orWhere('user_id', 0);
    }

    public function doramaFolders(): HasMany
    {
        return $this->hasMany(DoramaFolder::class);
    }

    public function doramaFoldersWithDefault(): HasMany
    {
        return $this->hasMany(DoramaFolder::class)->orWhere('user_id', 0);
    }

    public function favoriteAnimes(): HasManyThrough
    {
        return $this->hasManyThrough(Anime::class, FavoriteAnime::class, 'user_id', 'id', 'id', 'anime_id');
    }

    public function favoriteDoramas(): HasManyThrough
    {
        return $this->hasManyThrough(Dorama::class, FavoriteDorama::class, 'user_id', 'id', 'id', 'dorama_id');
    }

    public function getAvatarUrlAttribute(): ?string
    {
        return $this->avatar
            ? Storage::disk('s3_images')->url($this->avatar)
            : null;
    }
}
