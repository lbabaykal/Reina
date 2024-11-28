<?php

namespace App\Http\Controllers;

use App\Http\Filters\Fields\CountriesFilter;
use App\Http\Filters\Fields\GenresFilter;
use App\Http\Filters\Fields\SortingFilter;
use App\Http\Filters\Fields\StudiosFilter;
use App\Http\Filters\Fields\TitleFilter;
use App\Http\Filters\Fields\TypesFilter;
use App\Http\Filters\Fields\YearFromFilter;
use App\Http\Filters\Fields\YearToFilter;
use App\Models\Anime;
use App\Models\Country;
use App\Models\Dorama;
use App\Models\Genre;
use App\Models\Studio;
use App\Models\Type;
use App\Reina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\View\View;

class SearchController extends Controller
{

    public function __invoke(): View
    {
        $animes = Pipeline::send(Anime::query()
                ->select(['slug', 'poster', 'title_ru', 'rating', 'episodes_released', 'episodes_total'])
        )
            ->through([
                TitleFilter::class,
                TypesFilter::class,
                GenresFilter::class,
                CountriesFilter::class,
                StudiosFilter::class,
                YearFromFilter::class,
                YearToFilter::class,
                SortingFilter::class,
            ])
            ->thenReturn();

        $doramas = Pipeline::send(
            Dorama::query()
                ->select(['slug', 'poster', 'title_ru', 'rating', 'episodes_released', 'episodes_total'])
                ->latest('updated_at')
        )
            ->through([
                TitleFilter::class,
                TypesFilter::class,
                GenresFilter::class,
                CountriesFilter::class,
                StudiosFilter::class,
                YearFromFilter::class,
                YearToFilter::class,
                SortingFilter::class,
            ])
            ->thenReturn();

        return view('layouts.search.index')
            ->with('types', Type::all())
            ->with('genres', Genre::all())
            ->with('studios', Studio::all())
            ->with('countries', Country::all())
            ->with('animes', $animes->paginate(Reina::COUNT_ARTICLES_SEARCH)->withQueryString())
            ->with('doramas', $doramas->paginate(Reina::COUNT_ARTICLES_SEARCH)->withQueryString());
    }

}
