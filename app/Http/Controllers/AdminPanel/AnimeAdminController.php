<?php

namespace App\Http\Controllers\AdminPanel;

use App\Enums\AgeRatingEnum;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\AnimeStoreRequest;
use App\Http\Requests\AdminPanel\AnimeUpdateRequest;
use App\Models\Anime;
use App\Models\Country;
use App\Models\Genre;
use App\Models\Studio;
use App\Models\Type;
use App\Reina;
use App\Services\AnimeServices;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AnimeAdminController extends Controller
{
    public function index(): View
    {
        $animes = Anime::query()
            ->withoutGlobalScopes()
            ->select(['id', 'slug', 'title_ru', 'status', 'rating', 'type_id', 'episodes_released', 'episodes_total', 'updated_at'])
            ->with('type')
            ->latest('updated_at')
            ->paginate(Reina::COUNT_ADMIN_ITEMS)
            ->withQueryString();

        return view('admin.anime.index')->with('animes', $animes);
    }

    public function create(): View
    {
        $types = Type::all();
        $genres = Genre::all();
        $studios = Studio::all();
        $countries = Country::all();
        $age_ratings = AgeRatingEnum::cases();
        $statuses = StatusEnum::cases();

        return view('admin.anime.create')
            ->with('types', $types)
            ->with('genres', $genres)
            ->with('studios', $studios)
            ->with('countries', $countries)
            ->with('age_ratings', $age_ratings)
            ->with('statuses', $statuses);
    }

    public function store(AnimeStoreRequest $request, AnimeServices $animeServices): RedirectResponse
    {
        return $animeServices->store($request);
    }

    public function edit($slug): View
    {
        $anime = Anime::query()
            ->withoutGlobalScopes()
            ->findOrFail(getIdFromSlug($slug));

        $types = Type::all();
        $genres = Genre::all();
        $studios = Studio::all();
        $countries = Country::all();
        $age_ratings = AgeRatingEnum::cases();
        $statuses = StatusEnum::cases();

        return view('admin.anime.edit')
            ->with('anime', $anime)
            ->with('types', $types)
            ->with('genres', $genres)
            ->with('studios', $studios)
            ->with('countries', $countries)
            ->with('age_ratings', $age_ratings)
            ->with('statuses', $statuses);
    }

    public function update(AnimeUpdateRequest $request, $slug, AnimeServices $animeServices): RedirectResponse
    {
        $anime = Anime::query()
            ->withoutGlobalScopes()
            ->findOrFail(getIdFromSlug($slug));

        return $animeServices->update($request, $anime);
    }

    public function restore($slug): RedirectResponse
    {
        $anime = Anime::withTrashed()
            ->withoutGlobalScopes()
            ->findOrFail(getIdFromSlug($slug));

        $anime->restore();

        return redirect()->route('admin.anime.index')->with('message', "Аниме {$anime->title_ru} восстановлено.");
    }

    public function draft(): View
    {
        $animes = Anime::query()
            ->withoutGlobalScopes()
            ->select(['id', 'slug', 'title_ru', 'status', 'rating', 'type_id', 'status'])
            ->with('type')
            ->where('status', StatusEnum::DRAFT)
            ->latest('updated_at')
            ->paginate(Reina::COUNT_ADMIN_ITEMS)
            ->withQueryString();

        return view('admin.anime.index')->with('animes', $animes);
    }

    public function published(): View
    {
        $animes = Anime::query()
            ->withoutGlobalScopes()
            ->select(['id', 'slug', 'title_ru', 'status', 'rating', 'type_id', 'status'])
            ->with('type')
            ->where('status', StatusEnum::PUBLISHED)
            ->latest('updated_at')
            ->paginate(Reina::COUNT_ADMIN_ITEMS)
            ->withQueryString();

        return view('admin.anime.index')->with('animes', $animes);
    }

    public function archive(): View
    {
        $animes = Anime::query()
            ->withoutGlobalScopes()
            ->select(['id', 'slug', 'title_ru', 'status', 'rating', 'type_id', 'status'])
            ->with('type')
            ->where('status', StatusEnum::ARCHIVE)
            ->latest('updated_at')
            ->paginate(Reina::COUNT_ADMIN_ITEMS)
            ->withQueryString();

        return view('admin.anime.index')->with('animes', $animes);
    }

    public function deleted(): View
    {
        $animes = Anime::query()
            ->onlyTrashed()
            ->withoutGlobalScopes()
            ->select(['id', 'slug', 'title_ru', 'status', 'rating', 'type_id', 'status'])
            ->with('type')
            ->latest('updated_at')
            ->paginate(Reina::COUNT_ADMIN_ITEMS)
            ->withQueryString();

        return view('admin.anime.deleted')->with('animes', $animes);
    }

}
