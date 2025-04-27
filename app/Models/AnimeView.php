<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimeView extends Model
{
    protected $connection = 'timescale';

    protected $fillable = [
        'anime_id',
        'ip_address',
        'user_agent',
    ];

}
