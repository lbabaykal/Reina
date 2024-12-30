<?php

namespace App\Http\Filters\Fields;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class SortingFilter extends AbstractFilter
{
    public function applyFilter(Builder $builder): void
    {
        switch (request()->input('sorting')) {
            case 'date_updated':
                $builder->orderByDesc('updated_at');
                break;
            case 'rating':
                $builder->orderByDesc('rating');
                break;
            case 'premiere_asc':
                $builder->orderBy('release', 'ASC');
                break;
            case 'premiere_desc':
                $builder->orderBy('release', 'DESC');
                break;
            default:
                $builder->orderByDesc('updated_at');
                break;
        }
    }
}
