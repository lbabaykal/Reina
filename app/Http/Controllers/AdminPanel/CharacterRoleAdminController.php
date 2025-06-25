<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\CharacterRole\CharacterRoleStoreRequest;
use App\Http\Requests\AdminPanel\CharacterRole\CharacterRoleUpdateRequest;
use App\Models\CharacterRole;
use App\Reina;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CharacterRoleAdminController extends Controller
{
    public function index(): View
    {
        $characterRoles = CharacterRole::query()
            ->paginate(Reina::COUNT_ADMIN_ITEMS)
            ->withQueryString();

        return view('admin.character_role.index')
            ->with('characterRoles', $characterRoles);
    }

    public function create(): View
    {
        return view('admin.character_role.create');
    }

    public function store(CharacterRoleStoreRequest $request): RedirectResponse
    {
        $characterRole = CharacterRole::query()->create($request->validated());

        return redirect()
            ->route('admin.character-role.index')
            ->with('message', "Роль для персонажей {$characterRole->title} создана.");
    }

    public function edit(CharacterRole $characterRole): View
    {
        return view('admin.character_role.edit')
            ->with('characterRole', $characterRole);
    }

    public function update(CharacterRoleUpdateRequest $request, CharacterRole $characterRole): RedirectResponse
    {
        $characterRole->update($request->validated());

        return redirect()
            ->route('admin.character-role.index')
            ->with('message', "Роль для персонажей {$characterRole->title} обновлена.");
    }
}
