<?php

namespace App\Models;

use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Model;

class AnimeCharacter extends Model
{
    protected $fillable = [
        'anime_id',
        'character_id',
        'role',
    ];

    protected $casts = [
        'role' => RoleEnum::class,
    ];

}
