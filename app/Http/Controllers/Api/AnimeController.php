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
use App\Http\Resources\Animes\AnimesShowResource;
use App\Http\Resources\Animes\AnimesWatchResource;
use App\Http\Resources\Episodes\AnimeEpisodesResource;
use App\Models\Anime;
use App\Reina;
use App\Services\AnimesServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Pipeline;

class AnimeController extends Controller
{
    public function index(SearchRequest $request): AnonymousResourceCollection
    {
        $query = Anime::query()->select(['id', 'slug', 'poster', 'title_ru', 'rating', 'episodes_released', 'episodes_total', 'is_rating']);
        $animesPipeline = Pipeline::send(['query' => $query, 'validatedData' => $request->validated()])
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
        $animesFiltered = $animesPipeline['query'];

        return AnimesIndexResource::collection($animesFiltered->paginate(Reina::COUNT_ARTICLES_FULL, ['*'], 'page', $request->validated('page', 1)));
    }

    public function show($slug, AnimesServices $animesService): JsonResponse
    {
        $anime = $animesService->getDataFromCacheBySlug($slug);
        $ratingUser = $animesService->ratingUserFor();
        $favoriteUser = $animesService->favoriteUserFor();

        return response()->json([
            'dataAnime' => AnimesShowResource::make($anime),
            'dataUserForAnime' => [
                'rating' => $ratingUser,
                'favorite' => [
                    'folder_id' => $favoriteUser->anime_folder_id,
                    'episode_id' => $favoriteUser->anime_episode_id,
                ],
            ],
        ]);
    }

    public function watch($slug, AnimesServices $animesService): JsonResponse
    {
        $anime = $animesService->getDataFromCacheBySlug($slug);
        $ratingUser = $animesService->ratingUserFor();
        $favoriteUser = $animesService->favoriteUserFor();
        $episodes = $animesService->episodesFor();

        return response()->json([
            'dataAnime' => AnimesWatchResource::make($anime),
            'dataUserForAnime' => [
                'rating' => $ratingUser,
                'favorite' => [
                    'folder_id' => $favoriteUser->anime_folder_id,
                    'episode_id' => $favoriteUser->anime_episode_id,
                ],
            ],
            'dataEpisodes' => AnimeEpisodesResource::collection($episodes),
        ]);
    }
}
