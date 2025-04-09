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
use App\Http\Resources\Doramas\DoramasIndexResource;
use App\Http\Resources\Doramas\DoramasShowResource;
use App\Http\Resources\Doramas\DoramasWatchResource;
use App\Http\Resources\Episodes\DoramaEpisodesResource;
use App\Models\Dorama;
use App\Reina;
use App\Services\DoramasServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Pipeline;

class DoramaController extends Controller
{
    public function index(SearchRequest $request): AnonymousResourceCollection
    {
        $query = Dorama::query()->select(['id', 'slug', 'poster', 'title_ru', 'rating', 'episodes_released', 'episodes_total', 'is_rating']);
        $doramasPipeLine = Pipeline::send(['query' => $query, 'validatedData' => $request->validated()])
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
        $doramasFiltered = $doramasPipeLine['query'];

        return DoramasIndexResource::collection($doramasFiltered->paginate(Reina::COUNT_ARTICLES_FULL, ['*'], 'page', $request->validated('page', 1)));
    }

    public function show($slug, DoramasServices $doramasService): JsonResponse
    {
        $dorama = $doramasService->getDataFromCacheBySlug($slug);
        $ratingUser = $doramasService->ratingUserFor();
        $favoriteUser = $doramasService->favoriteUserFor();

        return response()->json([
            'dataDorama' => DoramasShowResource::make($dorama),
            'dataUserForDorama' => [
                'rating' => $ratingUser,
                'favorite' => [
                    'folder_id' => $favoriteUser->dorama_folder_id,
                    'episode_id' => $favoriteUser->dorama_episode_id,
                ],
            ],
        ]);
    }

    public function watch($slug, DoramasServices $doramasService): JsonResponse
    {
        $dorama = $doramasService->getDataFromCacheBySlug($slug);
        $ratingUser = $doramasService->ratingUserFor();
        $favoriteUser = $doramasService->favoriteUserFor();
        $episodes = $doramasService->episodesFor();

        return response()->json([
            'dataDorama' => DoramasWatchResource::make($dorama),
            'dataUserForDorama' => [
                'rating' => $ratingUser,
                'favorite' => [
                    'folder_id' => $favoriteUser->dorama_folder_id,
                    'episode_id' => $favoriteUser->dorama_episode_id,
                ],
            ],
            'dataEpisodes' => DoramaEpisodesResource::collection($episodes),
        ]);
    }
}
