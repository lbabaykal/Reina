<?php

namespace App\Http\Filters\Fields;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class TypesFilter extends AbstractFilter
{
    public function applyFilter(Builder $builder, array $validatedData): void
    {
        $builder->whereHas('type', function (Builder $query) use ($validatedData) {
            $query->whereIn('slug', $validatedData['types']);
        });
    }
}
