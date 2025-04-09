<?php

namespace App\Http\Filters\Fields;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class SortingFilter extends AbstractFilter
{
    public function applyFilter(Builder $builder, array $validatedData): void
    {
        match ($validatedData['sorting']) {
            'date_updated' => $builder->orderByDesc('updated_at'),
            'rating' => $builder->orderByDesc('rating'),
            'premiere_asc' => $builder->orderBy('release', 'ASC'),
            'premiere_desc' => $builder->orderBy('release', 'DESC'),
            default => $builder->orderByDesc('updated_at'),
        };
    }
}
