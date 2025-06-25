<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PersonRole extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'slug',
        'name',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::saved(function ($model) {
            cache()->forget($model->getTable());
        });

        static::deleted(function ($model) {
            cache()->forget($model->getTable());
        });
    }

    public function cache(): Collection
    {
        if (cache()->has($this->getTable())) {
            return cache()->get($this->getTable());
        }

        return cache()->rememberForever($this->getTable(), function () {
            return self::query()->orderBy('id')->get();
        });
    }
}
