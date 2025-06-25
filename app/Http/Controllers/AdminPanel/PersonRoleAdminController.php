<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\PersonRole\PersonRoleStoreRequest;
use App\Http\Requests\AdminPanel\PersonRole\PersonRoleUpdateRequest;
use App\Models\PersonRole;
use App\Reina;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PersonRoleAdminController extends Controller
{
    public function index(): View
    {
        $personRoles = PersonRole::query()
            ->paginate(Reina::COUNT_ADMIN_ITEMS)
            ->withQueryString();

        return view('admin.person_role.index')
            ->with('personRoles', $personRoles);
    }

    public function create(): View
    {
        return view('admin.person_role.create');
    }

    public function store(PersonRoleStoreRequest $request): RedirectResponse
    {
        $personRole = PersonRole::query()->create($request->validated());

        return redirect()
            ->route('admin.person-role.index')
            ->with('message', "Роль для персон {$personRole->title} создана.");
    }

    public function edit(PersonRole $personRole): View
    {
        return view('admin.person_role.edit')
            ->with('personRole', $personRole);
    }

    public function update(PersonRoleUpdateRequest $request, PersonRole $personRole): RedirectResponse
    {
        $personRole->update($request->validated());

        return redirect()
            ->route('admin.person-role.index')
            ->with('message', "Роль для персон {$personRole->title} обновлена.");
    }
}
