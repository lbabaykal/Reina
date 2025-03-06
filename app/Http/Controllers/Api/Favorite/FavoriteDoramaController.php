<?php

namespace App\Http\Controllers\Api\Favorite;

use App\Http\Controllers\Controller;
use App\Http\Requests\Favorite\FavoriteDoramasRequest;
use App\Models\Dorama;
use App\Models\DoramaFolder;
use App\Models\FavoriteDorama;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Lang;

class FavoriteDoramaController extends Controller
{
    public function show(): JsonResponse
    {
        $foldersUser = DoramaFolder::query()
            ->select(['id', 'title'])
            ->where('user_id', auth()->id())
            ->orWhere('user_id', 0)
            ->orderBy('id')
            ->get();

        return response()->json([
            'folders' => $foldersUser,
        ]);
    }

    public function store(FavoriteDoramasRequest $request, $doramaId): JsonResponse
    {
        $dorama = Dorama::query()
            ->select(['id', 'slug'])
            ->where('id', $doramaId)
            ->firstOrFail();

        $favoriteDorama = new FavoriteDorama([
            'user_id' => auth()->id(),
            'dorama_id' => $dorama->id,
            'dorama_folder_id' => $request->validated('folder_id'),
            'episode' => 0,
        ]);

        $favoriteDorama->save();

        return response()->json(Lang::get('reina.dorama.favorite_store'));
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

        return response()->json(Lang::get('reina.dorama.favorite_update'));
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

        return response()->json(Lang::get('reina.dorama.favorite_destroy'));
    }
}
