<?php

namespace App\Http\Controllers\Api\Folders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Folder\FolderDoramasRequest;
use App\Http\Resources\Doramas\DoramasIndexResource;
use App\Http\Resources\Folders\FolderResource;
use App\Http\Resources\Folders\FoldersDoramasResource;
use App\Models\FolderDorama;
use App\Reina;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class FolderDoramasController extends Controller
{
    public function allUserFolders(): JsonResponse
    {
        $folders = auth()->user()
            ->foldersDoramasWithDefault()
            ->withCount('favoritesDoramasUser')
            ->orderBy('folder_doramas.id')
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
            ->foldersDoramas()
            ->orderBy('folder_doramas.id')
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

        if ( $folderId > 0 ) {
            $folderDorama = FolderDorama::query()->findOrFail($folderId);
            Gate::authorize('view', $folderDorama);
        }

        $doramas = auth()->user()
            ->favoriteDoramas()
            ->when($folderId > 0, function ($query) use ($folderId) {
                return $query->where('folder_dorama_id', $folderId);
            })
            ->select(['slug', 'poster', 'title_ru', 'rating', 'episodes_released', 'episodes_total', 'favorite_doramas.updated_at'])
            ->latest('favorite_doramas.updated_at');

        return DoramasIndexResource::collection($doramas->paginate(Reina::COUNT_ARTICLES_FOLDERS, ['*'], 'page', request()->input('page', 1)));
    }

    public function store(FolderDoramasRequest $request): Response
    {
        Gate::authorize('create', FolderDorama::class);

        $folder = new FolderDorama();
        $folder->title = $request->input('title');
        $folder->user_id = auth()->id();
        $folder->save();

        return response()->noContent();
    }

    public function edit(FolderDorama $folder): JsonResponse
    {
        Gate::authorize('update', $folder);

        return response()->json([
            'folder' => FolderResource::make($folder),
        ]);
    }

    public function update(FolderDoramasRequest $request, FolderDorama $folder): Response
    {
        Gate::authorize('update', $folder);

        $folder->title = $request->input('title');
        $folder->update();

        return response()->noContent();
    }

    public function destroy(FolderDorama $folder): Response
    {
        Gate::authorize('delete', $folder);

        $folder->delete();

        return response()->noContent();
    }

}
