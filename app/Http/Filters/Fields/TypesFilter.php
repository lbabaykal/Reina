<?php

namespace App\Http\Filters\Fields;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class TypesFilter extends AbstractFilter
{
    public function applyFilter(Builder $builder): void
    {
        $builder->whereHas('type', function (Builder $query) {
            $query->whereIn('slug', request()->collect('types'));
        });
    }
}
