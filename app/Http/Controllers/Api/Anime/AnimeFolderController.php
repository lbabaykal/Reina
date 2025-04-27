<?php

namespace App\Http\Controllers\Api\Anime;

use App\Http\Controllers\Controller;
use App\Http\Requests\Folder\FolderCreateRequest;
use App\Http\Requests\Folder\FolderShowRequest;
use App\Http\Requests\Folder\FolderUpdateRequest;
use App\Http\Resources\Animes\AnimeIndexResource;
use App\Http\Resources\Folders\FolderAnimeResource;
use App\Http\Resources\Folders\FolderResource;
use App\Models\AnimeFolder;
use App\Reina;
use App\Services\AnimeFolderServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;

class AnimeFolderController extends Controller
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
            'allUserFolders' => FolderAnimeResource::collection($folders),
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
            'OnlyUserFolders' => FolderAnimeResource::collection($folders),
        ]);
    }

    public function show(FolderShowRequest $request): AnonymousResourceCollection
    {
        $folderId = $request->validated('folder', 0);

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

        return AnimeIndexResource::collection($animes->paginate(Reina::COUNT_ARTICLES_FOLDERS, ['*'], 'page', request()->input('page', 1)));
    }

    public function store(FolderCreateRequest $request): JsonResponse
    {
        Gate::authorize('create', AnimeFolder::class);

        $folder = new AnimeFolder;
        $folder->name = $request->validated('name');
        $folder->user_id = auth()->id();
        $folder->is_private = $request->validated('is_private');
        $folder->save();

        return response()->json(Lang::get('reina.folder.created', ['name' => $folder->name]));
    }

    public function edit(AnimeFolder $folder): JsonResponse
    {
        Gate::authorize('update', $folder);

        return response()->json([
            'folder' => FolderResource::make($folder),
        ]);
    }

    public function update(FolderUpdateRequest $request, AnimeFolder $folder): JsonResponse
    {
        Gate::authorize('update', $folder);

        $folder->name = $request->validated('name');
        $folder->is_private = $request->validated('is_private');
        $folder->update();

        return response()->json(Lang::get('reina.folder.updated', ['name' => $folder->name]));
    }

    public function destroy(AnimeFolder $folder): JsonResponse
    {
        Gate::authorize('delete', $folder);

        $folder->delete();

        return response()->json(Lang::get('reina.folder.deleted', ['name' => $folder->name]));
    }

    public function folders(AnimeFolderServices $animeFolderServices): AnonymousResourceCollection
    {
        return FolderResource::collection($animeFolderServices->foldersUserFor());
    }
}
