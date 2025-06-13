<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\CharacterStoreRequest;
use App\Http\Requests\AdminPanel\CharacterUpdateRequest;
use App\Models\Character;
use App\Reina;
use App\Services\CharacterServices;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CharacterAdminController extends Controller
{
    public function index(): View
    {
        $characters = Character::query()
            ->withoutGlobalScopes()
            ->latest('id')
            ->paginate(Reina::COUNT_ADMIN_ITEMS)
            ->withQueryString();

        return view('admin.characters.index')->with('characters', $characters);
    }

    public function create(): View
    {
        return view('admin.characters.create');
    }

    public function store(CharacterStoreRequest $request, CharacterServices $characterServices): RedirectResponse
    {
        return $characterServices->store($request);
    }

    public function edit($slug): View
    {
        $character = Character::query()
            ->withoutGlobalScopes()
            ->findOrFail(getIdFromSlug($slug));

        return view('admin.characters.edit')->with('character', $character);
    }

    public function update(CharacterUpdateRequest $request, $slug, CharacterServices $characterServices): RedirectResponse
    {
        $character = Character::query()
            ->withoutGlobalScopes()
            ->findOrFail(getIdFromSlug($slug));

        return $characterServices->update($request, $character);
    }

    public function destroy($slug, CharacterServices $characterServices): RedirectResponse
    {
        $character = Character::query()
            ->withoutGlobalScopes()
            ->findOrFail(getIdFromSlug($slug));

        return $characterServices->destroy($character);
    }
}
