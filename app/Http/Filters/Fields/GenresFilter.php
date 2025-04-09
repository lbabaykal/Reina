<?php

namespace App\Http\Filters\Fields;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class GenresFilter extends AbstractFilter
{
    public function applyFilter(Builder $builder, array $validatedData): void
    {
        $genreIds = $validatedData['genres'];

        if ($validatedData['strict_genre'] === 'true') {
            $builder->whereHas('genres', function (Builder $query) use ($genreIds) {
                $query->whereIn('slug', $genreIds);
            }, count($genreIds));
        } else {
            $builder->whereHas('genres', function (Builder $query) use ($genreIds) {
                $query->whereIn('slug', $genreIds);
            });
        }
    }
}
