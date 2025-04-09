<?php

namespace App\Http\Filters\Fields;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class YearFromFilter extends AbstractFilter
{
    public function applyFilter(Builder $builder, array $validatedData): void
    {
        $builder->whereYear('release', '>=', $validatedData['year_from']);
    }
}
