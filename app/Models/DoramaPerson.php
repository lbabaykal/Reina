<?php

namespace App\Models;

use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Model;

class DoramaPerson extends Model
{
    protected $fillable = [
        'dorama_id',
        'person_id',
        'role',
    ];

    protected $casts = [
        'role' => RoleEnum::class,
    ];

}
