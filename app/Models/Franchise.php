<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Franchise extends Model
{
    public $timestamps = false;

    public function franchiseables(): HasMany
    {
        return $this->hasMany(Franchiseable::class);
    }

    public function animes(): MorphToMany
    {
        return $this->morphedByMany(Anime::class, 'franchiseable');
    }

    public function doramas(): MorphToMany
    {
        return $this->morphedByMany(Dorama::class, 'franchiseable');
    }

}
