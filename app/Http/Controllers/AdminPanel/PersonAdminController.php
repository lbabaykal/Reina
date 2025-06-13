<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\PersonStoreRequest;
use App\Http\Requests\AdminPanel\PersonUpdateRequest;
use App\Models\Person;
use App\Reina;
use App\Services\PersonServices;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PersonAdminController extends Controller
{
    public function index(): View
    {
        $persons = Person::query()
            ->withoutGlobalScopes()
            ->latest('id')
            ->paginate(Reina::COUNT_ADMIN_ITEMS)
            ->withQueryString();

        return view('admin.persons.index')->with('persons', $persons);
    }

    public function create(): View
    {
        return view('admin.persons.create');
    }

    public function store(PersonStoreRequest $request, PersonServices $personServices): RedirectResponse
    {
        return $personServices->store($request);
    }

    public function edit($slug): View
    {
        $person = Person::query()
            ->withoutGlobalScopes()
            ->findOrFail(getIdFromSlug($slug));

        return view('admin.persons.edit')->with('person', $person);
    }

    public function update(PersonUpdateRequest $request, $slug, PersonServices $personServices): RedirectResponse
    {
        $person = Person::query()
            ->withoutGlobalScopes()
            ->findOrFail(getIdFromSlug($slug));

        return $personServices->update($request, $person);
    }

    public function destroy($slug, PersonServices $personServices): RedirectResponse
    {
        $person = Person::query()
            ->withoutGlobalScopes()
            ->findOrFail(getIdFromSlug($slug));

        return $personServices->destroy($person);
    }
}
