<?php

namespace App\Http\Controllers\Api\Folders;

use App\Http\Controllers\Controller;
use App\Http\Requests\FolderRequest;
use App\Http\Resources\Animes\AnimesIndexResource;
use App\Http\Resources\Folders\FolderResource;
use App\Http\Resources\Folders\FoldersAnimesResource;
use App\Models\AnimeFolder;
use App\Reina;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;

class FolderAnimesController extends Controller
{
    public function allUserFolders(): JsonResponse
    {
        $folders = auth()->user()
            ->animeFoldersWithDefault()
            ->withCount('favoritesAnimesUser')
            ->orderBy('anime_folders.id')
            ->get();

        $totalFavorites = $folders->sum('favorites_animes_user_count');

        return response()->json([
            'allUserFolders' => FoldersAnimesResource::collection($folders),
            'totalFavorites' => $totalFavorites,
        ]);
    }

    public function onlyUserFolders(): JsonResponse
    {
        $folders = auth()->user()
            ->animeFolders()
            ->orderBy('anime_folders.id')
            ->get();

        return response()->json([
            'OnlyUserFolders' => FoldersAnimesResource::collection($folders),
        ]);
    }

    public function show(): AnonymousResourceCollection
    {
        $validatedFolderId = request()->validate([
            'folder' => ['nullable', 'integer', 'min:0'],
        ]);

        $folderId = $validatedFolderId['folder'] ?? 0;

        if ($folderId > 0) {
            $folderAnime = AnimeFolder::query()->findOrFail($folderId);
            Gate::authorize('view', $folderAnime);
        }

        $animes = auth()->user()
            ->favoriteAnimes()
            ->when($folderId > 0, function ($query) use ($folderId) {
                return $query->where('anime_folder_id', $folderId);
            })
            ->select(['slug', 'poster', 'title_ru', 'rating', 'episodes_released', 'episodes_total', 'favorite_animes.updated_at'])
            ->latest('favorite_animes.updated_at');

        return AnimesIndexResource::collection($animes->paginate(Reina::COUNT_ARTICLES_FOLDERS, ['*'], 'page', request()->input('page', 1)));
    }

    public function store(FolderRequest $request): JsonResponse
    {
        Gate::authorize('create', AnimeFolder::class);

        $folder = new AnimeFolder;
        $folder->title = $request->validated('title');
        $folder->user_id = auth()->id();
        $folder->is_private = $request->validated('is_private');
        $folder->save();

        return response()->json(Lang::get('reina.folder.created', ['title' => $folder->title]));
    }

    public function edit(AnimeFolder $folder): JsonResponse
    {
        Gate::authorize('update', $folder);

        return response()->json([
            'folder' => FolderResource::make($folder),
        ]);
    }

    public function update(FolderRequest $request, AnimeFolder $folder): JsonResponse
    {
        Gate::authorize('update', $folder);

        $folder->title = $request->validated('title');
        $folder->is_private = $request->validated('is_private');
        $folder->update();

        return response()->json(Lang::get('reina.folder.updated', ['title' => $folder->title]));
    }

    public function destroy(AnimeFolder $folder): JsonResponse
    {
        Gate::authorize('delete', $folder);

        $folder->delete();

        return response()->json(Lang::get('reina.folder.deleted', ['title' => $folder->title]));
    }
}
