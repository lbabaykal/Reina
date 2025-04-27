<?php

namespace App\Http\Controllers\Api;

use App\Actions\Dorama\RecordDoramaViewAction;
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
use App\Http\Resources\Doramas\DoramaIndexResource;
use App\Http\Resources\Doramas\DoramaShowResource;
use App\Http\Resources\Doramas\DoramaWatchResource;
use App\Http\Resources\Episodes\DoramaEpisodesResource;
use App\Http\Resources\RelationsResource;
use App\Models\Dorama;
use App\Reina;
use App\Services\DoramaServices;
use App\Services\EpisodeServices;
use App\Services\FranchiseServices;
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

        return DoramaIndexResource::collection($doramasFiltered->paginate(Reina::COUNT_ARTICLES_FULL, ['*'], 'page', $request->validated('page', 1)));
    }

    public function show($slug, DoramaServices $doramasService): DoramaShowResource
    {
        $dorama = $doramasService->getDataFromCacheBySlug($slug);

        RecordDoramaViewAction::execute($dorama->id);

        return DoramaShowResource::make($dorama);
    }

    public function watch($slug, DoramaServices $doramasService): DoramaWatchResource
    {
        $dorama = $doramasService->getDataFromCacheBySlug($slug);

        RecordDoramaViewAction::execute($dorama->id);

        return DoramaWatchResource::make($dorama);
    }

    public function relations($slug, FranchiseServices $franchiseServices): AnonymousResourceCollection
    {
        $relations = $franchiseServices->relationsForDoramaById(getIdFromSlug($slug));

        return RelationsResource::collection($relations);
    }

    public function episodes($slug, EpisodeServices $episodeServices): AnonymousResourceCollection
    {
        $episodes = $episodeServices->episodesForDoramaById(getIdFromSlug($slug));

        return DoramaEpisodesResource::collection($episodes);
    }
}
