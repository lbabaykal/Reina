<?php

namespace App\Http\Filters\Fields;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class GenresFilter extends AbstractFilter
{
    public function applyFilter(Builder $builder): void
    {
        if (request()->boolean('strict_genre')) {
            //Поиск с сужением
            $genreIds = request()->collect('genres');
            $builder->whereHas('genres', function (Builder $query) use ($genreIds) {
                $query->whereIn('slug', $genreIds);
            }, count($genreIds));
        } else {
            //Поиск обычный
            $builder->whereHas('genres', function (Builder $query) {
                $query->whereIn('slug', request()->collect('genres'));
            });
        }
    }
}
