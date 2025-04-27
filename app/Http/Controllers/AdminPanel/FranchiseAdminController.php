<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanel\FranchiseStoreRequest;
use App\Http\Requests\AdminPanel\FranchiseUpdateRequest;
use App\Models\Franchise;
use App\Reina;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FranchiseAdminController extends Controller
{
    public function index(): View
    {
        $franchises = Franchise::query()->select(['slug', 'title_ru', 'title_en'])
            ->latest('id')
            ->paginate(Reina::COUNT_ADMIN_ITEMS)
            ->withQueryString();

        return view('admin.franchises.index')
            ->with('franchises', $franchises);
    }

    public function create(): View
    {
        return view('admin.franchises.create');
    }

    public function store(FranchiseStoreRequest $request): RedirectResponse
    {
        $franchise = Franchise::query()->create($request->validated());

        return redirect()
            ->route('admin.franchises.index')
            ->with('message', "Франшиза {$franchise->title_ru} добавлена.");
    }

    public function edit(Franchise $franchise): View
    {
        return view('admin.franchises.edit')
            ->with('franchise', $franchise);
    }

    public function update(FranchiseUpdateRequest $request, Franchise $franchise): RedirectResponse
    {
        $franchise->update($request->validated());

        return redirect()
            ->route('admin.franchises.index')
            ->with('message', "Франшиза {$franchise->title_ru} обновлена.");
    }
}
