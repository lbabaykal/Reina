<?php

namespace App\Http\Controllers\Api\Dorama;

use App\Http\Controllers\Controller;
use App\Http\Requests\Folder\FolderCreateRequest;
use App\Http\Requests\Folder\FolderShowRequest;
use App\Http\Requests\Folder\FolderUpdateRequest;
use App\Http\Resources\Doramas\DoramaIndexResource;
use App\Http\Resources\Folders\FolderResource;
use App\Http\Resources\Folders\FolderDoramaResource;
use App\Models\DoramaFolder;
use App\Reina;
use App\Services\DoramaFolderServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;

class DoramaFolderController extends Controller
{
    public function allUserFolders(): JsonResponse
    {
        $folders = auth()->user()
            ->doramaFoldersWithDefault()
            ->withCount('favoritesDoramasUser')
            ->orderBy('dorama_folders.id')
            ->get();

        $totalFavorites = $folders->sum('favorites_doramas_user_count');

        return response()->json([
            'allUserFolders' => FolderDoramaResource::collection($folders),
            'totalFavorites' => $totalFavorites,
        ]);
    }

    public function onlyUserFolders(): JsonResponse
    {
        $folders = auth()->user()
            ->doramaFolders()
            ->orderBy('dorama_folders.id')
            ->get();

        return response()->json([
            'OnlyUserFolders' => FolderDoramaResource::collection($folders),
        ]);
    }

    public function show(FolderShowRequest $request): AnonymousResourceCollection
    {
        $folderId = $request->validated('folder', 0);

        if ($folderId > 0) {
            $folderDorama = DoramaFolder::query()->findOrFail($folderId);
            Gate::authorize('view', $folderDorama);
        }

        $doramas = auth()->user()
            ->favoriteDoramas()
            ->when($folderId > 0, function ($query) use ($folderId) {
                return $query->where('dorama_folder_id', $folderId);
            })
            ->select(['slug', 'poster', 'title_ru', 'rating', 'episodes_released', 'episodes_total', 'favorite_doramas.updated_at'])
            ->latest('favorite_doramas.updated_at');

        return DoramaIndexResource::collection($doramas->paginate(Reina::COUNT_ARTICLES_FOLDERS, ['*'], 'page', request()->input('page', 1)));
    }

    public function store(FolderCreateRequest $request): JsonResponse
    {
        Gate::authorize('create', DoramaFolder::class);

        $folder = new DoramaFolder;
        $folder->name = $request->validated('name');
        $folder->user_id = auth()->id();
        $folder->is_private = $request->validated('is_private');
        $folder->save();

        return response()->json(Lang::get('reina.folder.created', ['name' => $folder->name]));
    }

    public function edit(DoramaFolder $folder): JsonResponse
    {
        Gate::authorize('update', $folder);

        return response()->json([
            'folder' => FolderResource::make($folder),
        ]);
    }

    public function update(FolderUpdateRequest $request, DoramaFolder $folder): JsonResponse
    {
        Gate::authorize('update', $folder);

        $folder->name = $request->validated('name');
        $folder->is_private = $request->validated('is_private');
        $folder->update();

        return response()->json(Lang::get('reina.folder.updated', ['name' => $folder->name]));
    }

    public function destroy(DoramaFolder $folder): JsonResponse
    {
        Gate::authorize('delete', $folder);

        $folder->delete();

        return response()->json(Lang::get('reina.folder.deleted', ['name' => $folder->name]));
    }

    public function folders(DoramaFolderServices $doramaFolderServices): AnonymousResourceCollection
    {
        return FolderResource::collection($doramaFolderServices->foldersUserFor());
    }
}
