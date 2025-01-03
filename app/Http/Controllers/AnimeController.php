<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
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
use App\Models\FolderAnime;
use App\Models\Genre;
use App\Models\Studio;
use App\Models\Type;
use App\Reina;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\View\View;

class AnimeController extends Controller
{

    public function index(): View
    {
        request()->merge(['sorting' => request()->input('sorting', 1)]);

        $animes = Pipeline::send(
            Anime::query()
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

        return view('layouts.anime.index')
            ->with('types', Type::all())
            ->with('genres', Genre::all())
            ->with('studios', Studio::all())
            ->with('countries', Country::all())
            ->with('animes', $animes->paginate(Reina::COUNT_ARTICLES_FULL)->withQueryString());
    }

    public function show($slug): View
    {
        $animeId = getIdFromSlug($slug);

        $anime = cache()->store('redis_animes')->remember('anime:'.$animeId, 600, function () use ($animeId) {
            return Anime::query()
                ->with('type')
                ->with('country')
                ->with('studios')
                ->with('genres')
                ->findOrFail($animeId);
        });

        $ratingUser = $anime->ratings()
            ->where('user_id', auth()->id())
            ->value('assessment');

        $favoriteUser = $anime->favorites()
            ->where('user_id', auth()->id())
            ->value('folder_anime_id');

        $foldersUser = FolderAnime::query()
            ->where('user_id', auth()->id())
            ->orWhere('user_id', 0)
            ->orderBy('id')
            ->get();

        return view('layouts.anime.show')
            ->with('anime', $anime)
            ->with('favoriteUser', $favoriteUser)
            ->with('ratingUser', $ratingUser)
            ->with('foldersUser', $foldersUser);
    }

    public function watch($slug): View
    {
        $animeId = getIdFromSlug($slug);

        $anime = cache()->store('redis_animes')->remember('anime_watch:'.$animeId, 600, function () use ($animeId) {
            return Anime::query()
                ->with('type')
                ->with('genres')
                ->findOrFail($animeId);
        });

        $ratingUser = $anime->ratings()
            ->where('user_id', auth()->id())
            ->value('assessment');

        $favoriteUser = $anime->favorites()
            ->where('user_id', auth()->id())
            ->value('folder_anime_id');

        $foldersUser = FolderAnime::query()
            ->where('user_id', auth()->id())
            ->orWhere('user_id', 0)
            ->orderBy('id')
            ->get();

        $episodes = $anime->animeEpisodes()
            ->where('status', StatusEnum::PUBLISHED)
            ->orderBy('number')
            ->get();

        return view('layouts.anime.watch')
            ->with('anime', $anime)
            ->with('favoriteUser', $favoriteUser)
            ->with('ratingUser', $ratingUser)
            ->with('foldersUser', $foldersUser)
            ->with('episodes', $episodes);
    }

}
