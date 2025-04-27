<?php

namespace App\Http\Controllers\Api;

use App\Actions\Anime\recordAnimeViewAction;
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
use App\Http\Resources\Animes\AnimeShowResource;
use App\Http\Resources\Animes\AnimeWatchResource;
use App\Http\Resources\Episodes\AnimeEpisodeResource;
use App\Http\Resources\RelationsResource;
use App\Models\Anime;
use App\Reina;
use App\Services\AnimeServices;
use App\Services\EpisodeServices;
use App\Services\FranchiseServices;
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

        return AnimeIndexResource::collection($animesFiltered->paginate(Reina::COUNT_ARTICLES_FULL, ['*'], 'page', $request->validated('page', 1)));
    }

    public function show($slug, AnimeServices $animesService): AnimeShowResource
    {
        $anime = $animesService->getDataFromCacheBySlug($slug);

        RecordAnimeViewAction::execute($anime->id);

        return AnimeShowResource::make($anime);
    }

    public function watch($slug, AnimeServices $animesService): AnimeWatchResource
    {
        $anime = $animesService->getDataFromCacheBySlug($slug);

        RecordAnimeViewAction::execute($anime->id);

        return AnimeWatchResource::make($anime);
    }

    public function relations($slug, FranchiseServices $franchiseServices): AnonymousResourceCollection
    {
        $relations = $franchiseServices->relationsForAnimeById(getIdFromSlug($slug));

        return RelationsResource::collection($relations);
    }

    public function episodes($slug, EpisodeServices $episodeServices): AnonymousResourceCollection
    {
        $episodes = $episodeServices->episodesForAnimeById(getIdFromSlug($slug));

        return AnimeEpisodeResource::collection($episodes);
    }
}
