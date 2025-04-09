<?php

namespace App\Http\Filters\Fields;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class GenresExcludeFilter extends AbstractFilter
{
    public function applyFilter(Builder $builder, array $validatedData): void
    {
        $builder->whereDoesntHave('genres', function (Builder $query) use ($validatedData) {
            $query->whereIn('slug', $validatedData['genres_exclude']);
        });
    }
}
