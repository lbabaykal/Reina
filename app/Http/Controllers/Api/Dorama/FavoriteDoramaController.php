<?php

namespace App\Http\Controllers\Api\Dorama;

use App\Http\Controllers\Controller;
use App\Http\Requests\Favorite\FavoriteDoramasEpisodeRequest;
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

    public function store(FavoriteDoramasRequest $request, int $id): JsonResponse
    {
        $dorama = Dorama::query()->select(['id', 'slug'])->findOrFail($id);

        $favorite = FavoriteDorama::query()
            ->updateOrCreate([
                'user_id' => auth()->id(),
                'dorama_id' => $dorama->id,
            ], [
                'dorama_folder_id' => $request->validated('folder_id'),
                'dorama_episode_id' => null,
            ]);

        return response()->json([
            'favorite' => [
                'folder_id' => $favorite->dorama_folder_id,
                'episode_id' => $favorite->dorama_episode_id ?? 0,
            ],
            'message' => Lang::get('reina.dorama.favorite_store'),
        ]);
    }

    public function update(FavoriteDoramasRequest $request, int $id): JsonResponse
    {
        $dorama = Dorama::query()->select(['id', 'slug'])->findOrFail($id);

        $dorama->favorites()
            ->where('user_id', auth()->id())
            ->update(['dorama_folder_id' => $request->validated('folder_id')]);

        $favorite = $dorama->favorites()
            ->select('dorama_folder_id', 'dorama_episode_id')
            ->where('user_id', auth()->id())
            ->first();

        return response()->json([
            'favorite' => [
                'folder_id' => $favorite->dorama_folder_id,
                'episode_id' => $favorite->dorama_episode_id ?? 0,
            ],
            'message' => Lang::get('reina.dorama.favorite_update'),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $dorama = Dorama::query()->select(['id', 'slug'])->findOrFail($id);

        $dorama->favorites()
            ->where('user_id', auth()->id())
            ->delete();

        return response()->json(Lang::get('reina.dorama.favorite_destroy'));
    }

    public function rememberEpisode(FavoriteDoramasEpisodeRequest $request, int $id): JsonResponse
    {
        $dorama = Dorama::query()->select(['id', 'slug'])->findOrFail($id);

        $favorite = $dorama->favorites()
            ->updateOrCreate([
                'user_id' => auth()->id(),
            ], [
                'dorama_folder_id' => $request->validated('folder_id') ?? 1,
                'dorama_episode_id' => $request->validated('episode_id'),
            ]);

        return response()->json([
            'favorite' => [
                'folder_id' => $favorite->dorama_folder_id,
                'episode_id' => $favorite->dorama_episode_id,
            ],
            'message' => Lang::get('reina.dorama.favorite_remember_episode'),
        ]);
    }

    public function forgetEpisode(int $id): JsonResponse
    {
        $dorama = Dorama::query()->select(['id', 'slug'])->findOrFail($id);

        $dorama->favorites()
            ->where('user_id', auth()->id())
            ->update(['dorama_episode_id' => null]);

        return response()->json(Lang::get('reina.dorama.favorite_forget_episode'));
    }
}
