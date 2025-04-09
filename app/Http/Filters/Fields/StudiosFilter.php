<?php

namespace App\Http\Filters\Fields;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class StudiosFilter extends AbstractFilter
{
    public function applyFilter(Builder $builder, array $validatedData): void
    {
        $studioIds = $validatedData['studios'];

        if ($validatedData['strict_studio'] === 'true') {
            $builder->whereHas('studios', function (Builder $query) use ($studioIds) {
                $query->whereIn('slug', $studioIds);
            }, count($studioIds));
        } else {
            $builder->whereHas('studios', function (Builder $query) use ($studioIds) {
                $query->whereIn('slug', $studioIds);
            });
        }
    }
}
