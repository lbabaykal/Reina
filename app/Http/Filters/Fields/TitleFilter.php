<?php

namespace App\Http\Filters\Fields;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class TitleFilter extends AbstractFilter
{
    public function applyFilter(Builder $builder, array $validatedData): void
    {
        $title = $validatedData['title'];

        if (! empty($title)) {
            $builder->where(function (Builder $query) use ($title) {
                $query->where('title_org', 'ILIKE', '%'.$title.'%')
                    ->orWhere('title_ru', 'ILIKE', '%'.$title.'%')
                    ->orWhere('title_en', 'ILIKE', '%'.$title.'%');
            });
        }
    }
}
