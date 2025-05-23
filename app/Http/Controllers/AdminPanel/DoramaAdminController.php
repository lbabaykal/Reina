<?php

namespace App\Http\Controllers\AdminPanel;

use App\Enums\AgeRatingEnum;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\DoramaStoreRequest;
use App\Http\Requests\AdminPanel\DoramaUpdateRequest;
use App\Models\Country;
use App\Models\Dorama;
use App\Models\Genre;
use App\Models\Studio;
use App\Models\Type;
use App\Reina;
use App\Services\DoramaAdminServices;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DoramaAdminController extends Controller
{
    public function index(): View
    {
        $doramas = Dorama::query()
            ->withoutGlobalScopes()
            ->select(['slug', 'title_ru', 'status', 'rating', 'type_id', 'episodes_released', 'episodes_total'])
            ->with('type')
            ->latest('updated_at')
            ->paginate(Reina::COUNT_ADMIN_ITEMS)
            ->withQueryString();

        return view('admin.dorama.index')->with('doramas', $doramas);
    }

    public function create(): View
    {
        $types = new Type()->cache();
        $genres = new Genre()->cache();
        $studios = new Studio()->cache();
        $countries = new Country()->cache();
        $age_ratings = AgeRatingEnum::cases();
        $statuses = StatusEnum::cases();

        return view('admin.dorama.create')
            ->with('types', $types)
            ->with('genres', $genres)
            ->with('studios', $studios)
            ->with('countries', $countries)
            ->with('age_ratings', $age_ratings)
            ->with('statuses', $statuses);
    }

    public function store(DoramaStoreRequest $request, DoramaAdminServices $doramaServices): RedirectResponse
    {
        return $doramaServices->store($request);
    }

    public function edit($slug): View
    {
        $dorama = Dorama::query()
            ->withoutGlobalScopes()
            ->findOrFail(getIdFromSlug($slug));

        $types = new Type()->cache();
        $genres = new Genre()->cache();
        $studios = new Studio()->cache();
        $countries = new Country()->cache();
        $age_ratings = AgeRatingEnum::cases();
        $statuses = StatusEnum::cases();

        return view('admin.dorama.edit')
            ->with('dorama', $dorama)
            ->with('types', $types)
            ->with('genres', $genres)
            ->with('studios', $studios)
            ->with('countries', $countries)
            ->with('age_ratings', $age_ratings)
            ->with('statuses', $statuses);
    }

    public function update(DoramaUpdateRequest $request, $slug, DoramaAdminServices $doramaServices): RedirectResponse
    {
        $dorama = Dorama::query()
            ->withoutGlobalScopes()
            ->findOrFail(getIdFromSlug($slug));

        return $doramaServices->update($request, $dorama);
    }

    public function restore($doramaSlug): RedirectResponse
    {
        $dorama = Dorama::withTrashed()
            ->withoutGlobalScopes()
            ->where('slug', $doramaSlug)
            ->firstOrFail();
        $dorama->restore();

        return redirect()->route('admin.dorama.index')->with('message', "Дорама {$dorama->title_ru} восстановлена.");
    }

    public function draft(): View
    {
        $doramas = Dorama::query()
            ->withoutGlobalScopes()
            ->select(['slug', 'title_ru', 'status', 'rating', 'type_id', 'country_id', 'status'])
            ->with('type')
            ->where('status', StatusEnum::DRAFT)
            ->latest('updated_at')
            ->paginate(Reina::COUNT_ADMIN_ITEMS)
            ->withQueryString();

        return view('admin.dorama.index')->with('doramas', $doramas);
    }

    public function published(): View
    {
        $doramas = Dorama::query()
            ->withoutGlobalScopes()
            ->select(['slug', 'title_ru', 'status', 'rating', 'type_id', 'country_id', 'status'])
            ->with('type')
            ->where('status', StatusEnum::PUBLISHED)
            ->latest('updated_at')
            ->paginate(Reina::COUNT_ADMIN_ITEMS)
            ->withQueryString();

        return view('admin.dorama.index')->with('doramas', $doramas);
    }

    public function inArchive(): View
    {
        $doramas = Dorama::query()
            ->withoutGlobalScopes()
            ->select(['slug', 'title_ru', 'status', 'rating', 'type_id', 'country_id', 'status'])
            ->with('type')
            ->where('status', StatusEnum::IN_ARCHIVE)
            ->latest('updated_at')
            ->paginate(Reina::COUNT_ADMIN_ITEMS)
            ->withQueryString();

        return view('admin.dorama.index')->with('doramas', $doramas);
    }

    public function onModeration(): View
    {
        $doramas = Dorama::query()
            ->withoutGlobalScopes()
            ->select(['slug', 'title_ru', 'status', 'rating', 'type_id', 'country_id', 'status'])
            ->with('type')
            ->where('status', StatusEnum::ON_MODERATION)
            ->latest('updated_at')
            ->paginate(Reina::COUNT_ADMIN_ITEMS)
            ->withQueryString();

        return view('admin.dorama.index')->with('doramas', $doramas);
    }

    public function deleted(): View
    {
        $doramas = Dorama::query()
            ->onlyTrashed()
            ->withoutGlobalScopes()
            ->select(['slug', 'title_ru', 'status', 'rating', 'type_id', 'country_id', 'status'])
            ->with('type')
            ->latest('updated_at')
            ->paginate(Reina::COUNT_ADMIN_ITEMS)
            ->withQueryString();

        return view('admin.dorama.deleted')->with('doramas', $doramas);
    }

}
