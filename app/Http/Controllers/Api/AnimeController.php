<?php

namespace App\Http\Controllers\Api;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Filters\Fields\CountriesFilter;
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
use App\Http\Resources\Episodes\AnimeResource;
use App\Models\Anime;
use App\Models\FolderAnime;
use App\Reina;
use App\Services\AnimesServices;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Pipeline;

class AnimeController extends Controller
{

    public function index(SearchRequest $request): AnonymousResourceCollection
    {
        $query = Anime::query()->select(['id', 'slug', 'poster', 'title_ru', 'rating', 'episodes_released', 'episodes_total']);

        $animes = Pipeline::send($query)
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

        return AnimesIndexResource::collection($animes->paginate(Reina::COUNT_ARTICLES_FULL, ['*'], 'page', request()->input('page', 1)));
    }

    public function show($slug, AnimesServices $animesService): Response
    {
        $anime = $animesService->dataInCacheBySlug($slug);
        $ratingUser = $animesService->ratingUserFor();
        $favoriteUser = $animesService->favoriteUserFor();
        $foldersUser = $animesService->foldersUserFor();
        $userFolderFavorite = $animesService->userFolderFavorite();

        return response([
            'dataAnime' => AnimesShowResource::make($anime),
            'dataUserForAnime' => [
                'rating' => $ratingUser,
                'favorite' => [
                    'id' => $userFolderFavorite->id,
                    'title' => $userFolderFavorite->title,
                ],
            ],
        ]);
    }

    public function watch($slug, AnimesServices $animesService): Response
    {
        $anime = $animesService->dataInCacheBySlug($slug);
        $ratingUser = $animesService->ratingUserFor();
        $favoriteUser = $animesService->favoriteUserFor();
        $foldersUser = $animesService->foldersUserFor();
        $userFolderFavorite = $animesService->userFolderFavorite();

        $episodes = $anime->animeEpisodes()
            ->where('status', StatusEnum::PUBLISHED)
            ->orderBy('number')
            ->get();

        return response([
            'dataAnime' => AnimesWatchResource::make($anime),
            'dataUserForAnime' => [
                'rating' => $ratingUser,
                'favorite' => [
                    'id' => $userFolderFavorite->id,
                    'title' => $userFolderFavorite->title,
                ],
            ],
            'dataEpisodes' => AnimeResource::collection($episodes),
        ]);
    }

}
