<?php

namespace App\Models;

use App\Enums\S3\DiskEnum;
use App\Observers\PersonObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

#[ObservedBy([PersonObserver::class])]
class Person extends Model
{
    protected $table = 'persons';

    public $timestamps = false;

    protected $fillable = [
        'full_name_org',
        'full_name_ru',
        'full_name_en',
        'photo',
        'date_of_birth',
        'description',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function animes(): BelongsToMany
    {
        return $this->belongsToMany(Anime::class)
            ->withPivot('role');
    }

    public function doramas(): BelongsToMany
    {
        return $this->belongsToMany(Dorama::class)
            ->withPivot('role');
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo
            ? Storage::disk(DiskEnum::IMAGES->value)->url($this->photo)
            : null;
    }
}
