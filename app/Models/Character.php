<?php

namespace App\Models;

use App\Enums\S3\DiskEnum;
use App\Observers\CharacterObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

#[ObservedBy([CharacterObserver::class])]
class Character extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'full_name_org',
        'full_name_ru',
        'full_name_en',
        'photo',
        'description',
    ];

    public function animes(): BelongsToMany
    {
        return $this->belongsToMany(Anime::class)
            ->withPivot('role');
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo
            ? Storage::disk(DiskEnum::IMAGES->value)->url($this->photo)
            : null;
    }
}
