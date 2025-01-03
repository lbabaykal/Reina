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
use App\Http\Resources\DoramasIndexResource;
use App\Models\Dorama;
use App\Models\FolderDorama;
use App\Reina;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\View\View;

class DoramaController extends Controller
{
    public function index(SearchRequest $request)
    {
        $query = Dorama::query()->select(['id', 'slug', 'poster', 'title_ru', 'rating', 'episodes_released', 'episodes_total']);
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

        return DoramasIndexResource::collection($animes->paginate(Reina::COUNT_ARTICLES_FULL, ['*'], 'page', request()->input('page', 1)));
    }

    public function show($slug): View
    {
        $dorama = cache()->store('redis_doramas')->remember('dorama:'.$slug, 600, function () use ($slug) {
            return Dorama::query()
                ->where('slug', $slug)
                ->with('type')
                ->with('country')
                ->with('studios')
                ->with('genres')
                ->firstOrFail();
        });

        $ratingUser = $dorama->ratings()
            ->where('user_id', auth()->id())
            ->value('assessment');

        $favoriteUser = $dorama->favorites()
            ->where('user_id', auth()->id())
            ->value('folder_dorama_id');

        $foldersUser = FolderDorama::query()
            ->where('user_id', auth()->id())
            ->orWhere('user_id', 0)
            ->orderBy('id')
            ->get();

        return view('layouts.dorama.show')
            ->with('dorama', $dorama)
            ->with('favoriteUser', $favoriteUser)
            ->with('ratingUser', $ratingUser)
            ->with('foldersUser', $foldersUser);
    }

    public function watch($slug): View
    {
        $dorama = cache()->store('redis_doramas')->remember('dorama_watch:'.$slug, 600, function () use ($slug) {
            return Dorama::query()
                ->where('slug', $slug)
                ->with('type')
                ->with('genres')
                ->firstOrFail();
        });

        $ratingUser = $dorama->ratings()
            ->where('user_id', auth()->id())
            ->value('assessment');

        $favoriteUser = $dorama->favorites()
            ->where('user_id', auth()->id())
            ->value('folder_dorama_id');

        $foldersUser = FolderDorama::query()
            ->where('user_id', auth()->id())
            ->orWhere('user_id', 0)
            ->orderBy('id')
            ->get();

        $episodes = $dorama->doramaEpisodes()
            ->where('status', StatusEnum::PUBLISHED)
            ->orderBy('number')
            ->get();

        return view('layouts.dorama.watch')
            ->with('dorama', $dorama)
            ->with('favoriteUser', $favoriteUser)
            ->with('ratingUser', $ratingUser)
            ->with('foldersUser', $foldersUser)
            ->with('episodes', $episodes);
    }

}
