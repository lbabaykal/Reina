<?php

namespace App\Http\Filters\Fields;

use App\Http\Filters\AbstractFilter;
use Illuminate\Database\Eloquent\Builder;

class CountriesFilter extends AbstractFilter
{
    public function applyFilter(Builder $builder, array $validatedData): void
    {
        //        if (request()->boolean('strict_country')) {
        //            //Поиск с сужением
        //            $countryIds = request()->collect('country');
        //            $builder->whereHas('countries', function (Builder $query) use ($countryIds) {
        //                $query->whereIn('country_id', $countryIds);
        //            }, count($countryIds));
        //        } else {
        //            //Поиск обычный
        //            $builder->whereHas('countries', function (Builder $query) {
        //                $query->whereIn('country_id', request()->collect('country'));
        //            });
        //        }

        $builder->whereHas('countries', function (Builder $query) use ($validatedData) {
            $query->whereIn('slug', $validatedData['countries']);
        });
    }
}
