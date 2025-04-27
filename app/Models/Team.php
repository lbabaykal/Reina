<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'isVerified',
    ];

    protected $casts = [
        'isVerified' => 'boolean',
    ];

}
