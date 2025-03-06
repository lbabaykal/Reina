<?php

namespace App\Http\Controllers\Api\Folders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Folder\DoramaFoldersRequest;
use App\Http\Resources\Doramas\DoramasIndexResource;
use App\Http\Resources\Folders\FolderResource;
use App\Http\Resources\Folders\FoldersDoramasResource;
use App\Models\DoramaFolder;
use App\Reina;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;

class FolderDoramasController extends Controller
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
            'allUserFolders' => FoldersDoramasResource::collection($folders),
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
            'OnlyUserFolders' => FoldersDoramasResource::collection($folders),
        ]);
    }

    public function show(): AnonymousResourceCollection
    {
        request()->validate([
            'folder' => ['nullable', 'integer', 'min:0'],
        ]);

        $folderId = request()->input('folder', 0);

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

        return DoramasIndexResource::collection($doramas->paginate(Reina::COUNT_ARTICLES_FOLDERS, ['*'], 'page', request()->input('page', 1)));
    }

    public function store(DoramaFoldersRequest $request): JsonResponse
    {
        Gate::authorize('create', DoramaFolder::class);

        $folder = new DoramaFolder;
        $folder->title = $request->input('title');
        $folder->user_id = auth()->id();
        $folder->is_private = true; // TODO доделать функционал папок
        $folder->save();

        return response()->json(Lang::get('reina.folder.created', ['title' => $folder->title]));
    }

    public function edit(DoramaFolder $folder): JsonResponse
    {
        Gate::authorize('update', $folder);

        return response()->json([
            'folder' => FolderResource::make($folder),
        ]);
    }

    public function update(DoramaFoldersRequest $request, DoramaFolder $folder): JsonResponse
    {
        Gate::authorize('update', $folder);

        $folder->title = $request->input('title'); // TODO доделать функционал папок
        $folder->update();

        return response()->json(Lang::get('reina.folder.updated', ['title' => $folder->title]));
    }

    public function destroy(DoramaFolder $folder): JsonResponse
    {
        Gate::authorize('delete', $folder);

        $folder->delete();

        return response()->json(Lang::get('reina.folder.deleted', ['title' => $folder->title]));
    }
}
