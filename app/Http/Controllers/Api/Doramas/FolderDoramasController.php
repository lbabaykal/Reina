<?php

namespace App\Http\Controllers\Api\Doramas;

use App\Http\Controllers\Controller;
use App\Http\Resources\Doramas\DoramasIndexResource;
use App\Http\Resources\Folders\FoldersDoramasResource;
use App\Reina;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FolderDoramasController extends Controller
{
    public function index(): JsonResponse
    {
        $folders = auth()->user()
            ->foldersDoramasWithDefault()
            ->withCount('favoritesDoramasUser')
            ->orderBy('folder_doramas.id')
            ->get();

        $totalFavorites = $folders->sum('favorites_doramas_user_count');

        return response()->json([
            'folders' => FoldersDoramasResource::collection($folders),
            'totalFavorites' => $totalFavorites,
        ]);
    }

    public function show(): AnonymousResourceCollection
    {
        request()->validate([
            'folder' => ['nullable', 'integer', 'min:0'],
        ]);

        $folderId = request()->input('folder', 0);

        $doramas = auth()->user()
            ->favoriteDoramas()
            ->when($folderId > 0, function ($query) use ($folderId) {
                return $query->where('folder_dorama_id', $folderId);
            })
            ->select(['slug', 'poster', 'title_ru', 'rating', 'episodes_released', 'episodes_total', 'favorite_doramas.updated_at'])
            ->latest('favorite_doramas.updated_at');

        return DoramasIndexResource::collection($doramas->paginate(Reina::COUNT_ARTICLES_FOLDERS, ['*'], 'page', request()->input('page', 1)));
    }

}
