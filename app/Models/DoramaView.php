<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoramaView extends Model
{
    protected $connection = 'timescale';

    protected $fillable = [
        'dorama_id',
        'ip_address',
        'user_agent',
    ];
}
