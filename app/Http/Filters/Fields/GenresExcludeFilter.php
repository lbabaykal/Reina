<?php

namespace App\Http\Filters\Fields;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class GenresExcludeFilter extends AbstractFilter
{
    public function applyFilter(Builder $builder): void
    {
        $builder->whereDoesntHave('genres', function (Builder $query) {
            $query->whereIn('slug', request()->collect('genres_exclude'));
        });
    }
}
