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
use App\Http\Resources\Animes\AnimesIndexResource;
use App\Http\Resources\CountriesResource;
use App\Http\Resources\Doramas\DoramasIndexResource;
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
use Illuminate\Support\Facades\Pipeline;

class SearchController extends Controller
{
    public function index(SearchRequest $request): JsonResponse
    {
        $queryAnime = Anime::query()->select(['id', 'slug', 'poster', 'title_ru', 'rating', 'episodes_released', 'episodes_total', 'is_rating'])->limit(8);
        $animesFiltered = Pipeline::send($queryAnime)
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
        $dataAnimes = $animesFiltered->get();
        $animesTotalFound = $animesFiltered->count();

        $queryDorama = Dorama::query()->select(['id', 'slug', 'poster', 'title_ru', 'rating', 'episodes_released', 'episodes_total', 'is_rating'])->limit(8);
        $doramasFiltered = Pipeline::send($queryDorama)
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
        $dataDoramas = $doramasFiltered->get();
        $doramasTotalFound = $doramasFiltered->count();

        return response()->json([
            'dataAnimes' => AnimesIndexResource::collection($dataAnimes),
            'animesTotalFound' => $animesTotalFound,
            'dataDoramas' => DoramasIndexResource::collection($dataDoramas),
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
                ['id' => 1, 'title' => 'По дате обновления', 'slug' => 'date_updated'],
                ['id' => 2, 'title' => 'По рейтингу', 'slug' => 'rating'],
                ['id' => 3, 'title' => 'По дате выхода ▲', 'slug' => 'premiere_asc'],
                ['id' => 4, 'title' => 'По дате выхода ▼', 'slug' => 'premiere_desc'],
            ],
        ]);
    }
}
