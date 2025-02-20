<?php

namespace App\Http\Controllers\Api\Folders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Folder\FolderAnimesRequest;
use App\Http\Resources\Animes\AnimesIndexResource;
use App\Http\Resources\Folders\FolderResource;
use App\Http\Resources\Folders\FoldersAnimesResource;
use App\Models\FolderAnime;
use App\Reina;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class FolderAnimesController extends Controller
{
    public function allUserFolders(): JsonResponse
    {
        $folders = auth()->user()
            ->foldersAnimesWithDefault()
            ->withCount('favoritesAnimesUser')
            ->orderBy('folder_animes.id')
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
            ->foldersAnimes()
            ->orderBy('folder_animes.id')
            ->get();

        return response()->json([
            'OnlyUserFolders' => FoldersAnimesResource::collection($folders),
        ]);
    }

    public function show(): AnonymousResourceCollection
    {
        request()->validate([
            'folder' => ['nullable', 'integer', 'min:0'],
        ]);

        $folderId = request()->input('folder', 0);

        if ( $folderId > 0 ) {
            $folderAnime = FolderAnime::query()->findOrFail($folderId);
            Gate::authorize('view', $folderAnime);
        }

        $animes = auth()->user()
            ->favoriteAnimes()
            ->when($folderId > 0, function ($query) use ($folderId) {
                return $query->where('folder_anime_id', $folderId);
            })
            ->select(['slug', 'poster', 'title_ru', 'rating', 'episodes_released', 'episodes_total', 'favorite_animes.updated_at'])
            ->latest('favorite_animes.updated_at');

        return AnimesIndexResource::collection($animes->paginate(Reina::COUNT_ARTICLES_FOLDERS, ['*'], 'page', request()->input('page', 1)));
    }

    public function store(FolderAnimesRequest $request): Response
    {
        Gate::authorize('create', FolderAnime::class);

        $folder = new FolderAnime();
        $folder->title = $request->input('title');
        $folder->user_id = auth()->id();
        $folder->save();

        return response()->noContent();
    }

    public function edit(FolderAnime $folder): JsonResponse
    {
        Gate::authorize('update', $folder);

        return response()->json([
            'folder' => FolderResource::make($folder),
        ]);
    }

    public function update(FolderAnimesRequest $request, FolderAnime $folder): Response
    {
        Gate::authorize('update', $folder);

        $folder->title = $request->input('title');
        $folder->update();

        return response()->noContent();
    }

    public function destroy(FolderAnime $folder): Response
    {
        Gate::authorize('delete', $folder);

        $folder->delete();

        return response()->noContent();
    }

}
