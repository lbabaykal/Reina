<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Filters\Fields\CountriesFilter;
use App\Http\Filters\Fields\GenresExcludeFilter;
use App\Http\Filters\Fields\GenresFilter;
use App\Http\Filters\Fields\SortingFilter;
use App\Http\Filters\Fields\StudiosFilter;
use App\Http\Filters\Fields\TitleFilter;
use App\Http\Filters\Fields\TypesFilter;
use App\Http\Filters\Fields\YearFromFilter;
use App\Http\Filters\Fields\YearToFilter;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\Animes\AnimeIndexResource;
use App\Http\Resources\CountriesResource;
use App\Http\Resources\Doramas\DoramaIndexResource;
use App\Http\Resources\GenresResource;
use App\Http\Resources\StudiosResource;
use App\Http\Resources\TypesResource;
use App\Models\Anime;
use App\Models\Country;
use App\Models\Dorama;
use App\Models\Genre;
use App\Models\Studio;
use App\Models\Type;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Pipeline;

class SearchController extends Controller
{
    public function index(SearchRequest $request): JsonResponse
    {
        $queryAnime = Anime::query()->select(['id', 'slug', 'poster', 'title_ru', 'rating', 'episodes_released', 'episodes_total', 'is_rating'])->limit(8);
        $animesFiltered = Pipeline::send(['query' => $queryAnime, 'validatedData' => $request->validated()])
            ->through([
                TitleFilter::class,
                TypesFilter::class,
                GenresFilter::class,
                GenresExcludeFilter::class,
                CountriesFilter::class,
                StudiosFilter::class,
                YearFromFilter::class,
                YearToFilter::class,
                SortingFilter::class,
            ])
            ->thenReturn();

        $dataAnimes = $animesFiltered['query']->get();
        $animesTotalFound = $animesFiltered['query']->count();

        $queryDorama = Dorama::query()->select(['id', 'slug', 'poster', 'title_ru', 'rating', 'episodes_released', 'episodes_total', 'is_rating'])->limit(8);
        $doramasFiltered = Pipeline::send(['query' => $queryDorama, 'validatedData' => $request->validated()])
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
        $dataDoramas = $doramasFiltered['query']->get();
        $doramasTotalFound = $doramasFiltered['query']->count();

        return response()->json([
            'dataAnimes' => AnimeIndexResource::collection($dataAnimes),
            'animesTotalFound' => $animesTotalFound,
            'dataDoramas' => DoramaIndexResource::collection($dataDoramas),
            'doramasTotalFound' => $doramasTotalFound,
        ]);
    }

    public function searchData(): JsonResponse
    {
        return response()->json([
            'types' => TypesResource::collection((new Type)->cache()),
            'genres' => GenresResource::collection((new Genre)->cache()),
            'studios' => StudiosResource::collection((new Studio)->cache()),
            'countries' => CountriesResource::collection((new Country)->cache()),
            'sorting' => [
                ['id' => 1, 'title' => Lang::get('reina.sort.by_update_date'), 'slug' => 'date_updated'],
                ['id' => 2, 'title' => Lang::get('reina.sort.by_rating'), 'slug' => 'rating'],
                ['id' => 3, 'title' => Lang::get('reina.sort.by_release_date_as'), 'slug' => 'premiere_asc'],
                ['id' => 4, 'title' => Lang::get('reina.sort.by_release_date_desc'), 'slug' => 'premiere_desc'],
            ],
        ]);
    }
}
