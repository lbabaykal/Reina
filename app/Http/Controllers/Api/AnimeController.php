<?php

namespace App\Http\Controllers\Api;

use App\Enums\StatusEnum;
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
        $animes = Pipeline::send($query)
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

        return AnimesIndexResource::collection($animes->paginate(Reina::COUNT_ARTICLES_FULL, ['*'], 'page', request()->input('page', 1)));
    }

    public function show($slug, AnimesServices $animesService): JsonResponse
    {
        $anime = $animesService->dataInCacheBySlug($slug);
        $ratingUser = $animesService->ratingUserFor();
        $favoriteUser = $animesService->favoriteUserFor();

        return response()->json([
            'dataAnime' => AnimesShowResource::make($anime),
            'dataUserForAnime' => [
                'rating' => $ratingUser,
                'favorite' => [
                    'folder_id' => $favoriteUser->anime_folder_id,
                    'episode' => $favoriteUser->episode,
                ],
            ],
        ]);
    }

    public function watch($slug, AnimesServices $animesService): JsonResponse
    {
        $anime = $animesService->dataInCacheBySlug($slug);
        $ratingUser = $animesService->ratingUserFor();
        $favoriteUser = $animesService->favoriteUserFor();

        /** @var Anime $anime */
        $episodes = $anime->episodes()
            ->where('status', StatusEnum::PUBLISHED)
            ->orderBy('number')
            ->get();

        return response()->json([
            'dataAnime' => AnimesWatchResource::make($anime),
            'dataUserForAnime' => [
                'rating' => $ratingUser,
                'favorite' => [
                    'folder_id' => $favoriteUser->anime_folder_id,
                    'episode' => $favoriteUser->episode,
                ],
            ],
            'dataEpisodes' => AnimeEpisodesResource::collection($episodes),
        ]);
    }
}
