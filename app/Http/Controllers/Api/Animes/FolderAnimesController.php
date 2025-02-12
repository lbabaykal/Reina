<?php

namespace App\Http\Controllers\Api\Animes;

use App\Http\Controllers\Controller;
use App\Http\Requests\FolderAnimesRequest;
use App\Http\Resources\Animes\AnimesIndexResource;
use App\Http\Resources\Folders\FoldersAnimesResource;
use App\Models\FolderAnime;
use App\Reina;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class FolderAnimesController extends Controller
{
    public function index(): JsonResponse
    {
        $folders = auth()->user()
            ->foldersAnimesWithDefault()
            ->withCount('favoritesAnimesUser')
            ->orderBy('folder_animes.id')
            ->get();

        $totalFavorites = $folders->sum('favorites_animes_user_count');

        return response()->json([
            'folders' => FoldersAnimesResource::collection($folders),
            'totalFavorites' => $totalFavorites,
        ]);
    }

    public function show(): AnonymousResourceCollection
    {
        request()->validate([
            'folder' => ['nullable', 'integer', 'min:0'],
        ]);

        $folderId = request()->input('folder', 0);

        $animes = auth()->user()
            ->favoriteAnimes()
            ->when($folderId > 0, function ($query) use ($folderId) {
                return $query->where('folder_anime_id', $folderId);
            })
            ->select(['slug', 'poster', 'title_ru', 'rating', 'episodes_released', 'episodes_total', 'favorite_animes.updated_at'])
            ->latest('favorite_animes.updated_at');

        return AnimesIndexResource::collection($animes->paginate(Reina::COUNT_ARTICLES_FOLDERS, ['*'], 'page', request()->input('page', 1)));
    }















































    public function store(FolderAnimesRequest $request): RedirectResponse
    {
        $response = Gate::inspect('create', FolderAnime::class);

        if ($response->denied()) {
            return redirect()
                ->route('user.folders.animes.index')
                ->with('message', $response->message());
        }

        $folder = new FolderAnime();
        $folder->title = $request->input('title');
        $folder->user_id = auth()->id();
        $folder->save();

        return redirect()->route('user.folders.animes.index')
            ->with('message', "Папка {$folder->title} создана.");
    }

    public function update(FolderAnimesRequest $request, FolderAnime $folder): RedirectResponse
    {
        Gate::authorize('update', $folder);

        $folder->title = $request->input('title');
        $folder->update();

        return redirect()->route('user.folders.animes.index')
            ->with('message', "Папка {$folder->title} изменана.");
    }

    public function destroy(FolderAnime $folder): RedirectResponse
    {
        Gate::authorize('delete', $folder);

        $folder->delete();

        return redirect()->route('user.folders.animes.index')
            ->with('message', "Папка {$folder->title} удалена.");
    }

}
