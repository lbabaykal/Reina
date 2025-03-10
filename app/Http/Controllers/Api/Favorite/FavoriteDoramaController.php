<?php

namespace App\Http\Controllers\Api\Favorite;

use App\Http\Controllers\Controller;
use App\Http\Requests\Favorite\FavoriteDoramasChangeEpisodeRequest;
use App\Http\Requests\Favorite\FavoriteDoramasRequest;
use App\Models\Dorama;
use App\Models\FavoriteDorama;
use App\Services\DoramaFolderServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Lang;

class FavoriteDoramaController extends Controller
{
    public function show(): JsonResponse
    {
        return response()->json([
            'folders' => new DoramaFolderServices()->foldersUserFor(),
        ]);
    }

    public function store(FavoriteDoramasRequest $request, $doramaId): JsonResponse
    {
        $dorama = Dorama::query()
            ->select(['id', 'slug'])
            ->where('id', $doramaId)
            ->firstOrFail();

        $favorite = FavoriteDorama::query()
            ->updateOrCreate([
                'user_id' => auth()->id(),
                'dorama_id' => $dorama->id,
            ],[
                'dorama_folder_id' => $request->validated('folder_id'),
                'episode' => 0,
            ]);

        return response()->json([
            'favorite' => [
                'folder_id' => $favorite->dorama_folder_id,
                'episode' => $favorite->episode,
            ],
            'message' => Lang::get('reina.dorama.favorite_store'),
        ]);
    }

    public function update(FavoriteDoramasRequest $request, $doramaId): JsonResponse
    {
        $dorama = Dorama::query()
            ->select(['id', 'slug'])
            ->where('id', $doramaId)
            ->firstOrFail();

        $dorama->favorites()
            ->where('user_id', auth()->id())
            ->update(['dorama_folder_id' => $request->validated('folder_id')]);

        return response()->json([
            'message' => Lang::get('reina.dorama.favorite_update'),
        ]);
    }

    public function destroy($doramaId): JsonResponse
    {
        $dorama = Dorama::query()
            ->select(['id', 'slug'])
            ->where('id', $doramaId)
            ->firstOrFail();

        $dorama->favorites()
            ->where('user_id', auth()->id())
            ->delete();

        return response()->json([
            'message' => Lang::get('reina.dorama.favorite_destroy'),
        ]);
    }

    public function changeEpisode(FavoriteDoramasChangeEpisodeRequest $request, $doramaId): JsonResponse
    {
        $dorama = Dorama::query()
            ->select(['id', 'slug'])
            ->where('id', $doramaId)
            ->firstOrFail();

        $favorite = $dorama->favorites()
            ->updateOrCreate([
                'user_id' => auth()->id(),
            ], [
                'dorama_folder_id' => $request->validated('folder_id', 1),
                'episode' => $request->validated('episode'),
            ]);

        return response()->json([
            'favorite' => [
                'folder_id' => $favorite->dorama_folder_id,
                'episode' => $favorite->episode,
            ],
            'message' => Lang::get('reina.dorama.favorite_change_episode'),
        ]);
    }
}
