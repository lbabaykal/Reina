<?php

namespace App\Http\Controllers\Api\Favorite;

use App\Http\Controllers\Controller;
use App\Http\Requests\Favorite\FavoriteAnimesChangeEpisodeRequest;
use App\Http\Requests\Favorite\FavoriteAnimesRequest;
use App\Models\Anime;
use App\Models\FavoriteAnime;
use App\Services\AnimeFolderServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Lang;

class FavoriteAnimeController extends Controller
{
    public function show(): JsonResponse
    {
        return response()->json([
            'folders' => new AnimeFolderServices()->foldersUserFor(),
        ]);
    }

    public function store(FavoriteAnimesRequest $request, $animeId): JsonResponse
    {
        $anime = Anime::query()
            ->select(['id', 'slug'])
            ->where('id', $animeId)
            ->firstOrFail();

        $favorite = FavoriteAnime::query()
            ->updateOrCreate([
                'user_id' => auth()->id(),
                'anime_id' => $anime->id,
            ], [
                'anime_folder_id' => $request->validated('folder_id'),
                'episode' => 0,
            ]);

        return response()->json([
            'favorite' => [
                'folder_id' => $favorite->anime_folder_id,
                'episode' => $favorite->episode,
            ],
            'message' => Lang::get('reina.anime.favorite_store'),
        ]);
    }

    public function update(FavoriteAnimesRequest $request, $animeId): JsonResponse
    {
        $anime = Anime::query()
            ->select(['id', 'slug'])
            ->where('id', $animeId)
            ->firstOrFail();

        $anime->favorites()
            ->where('user_id', auth()->id())
            ->update(['anime_folder_id' => $request->validated('folder_id')]);

        return response()->json([
            'message' => Lang::get('reina.anime.favorite_update'),
        ]);
    }

    public function destroy($animeId): JsonResponse
    {
        $anime = Anime::query()
            ->select(['id', 'slug'])
            ->where('id', $animeId)
            ->firstOrFail();

        $anime->favorites()
            ->where('user_id', auth()->id())
            ->delete();

        return response()->json([
            'message' => Lang::get('reina.anime.favorite_destroy'),
        ]);
    }

    public function changeEpisode(FavoriteAnimesChangeEpisodeRequest $request, $animeId): JsonResponse
    {
        $anime = Anime::query()
            ->select(['id', 'slug'])
            ->where('id', $animeId)
            ->firstOrFail();

        $favorite = $anime->favorites()
            ->updateOrCreate([
                'user_id' => auth()->id(),
            ], [
                'anime_folder_id' => $request->validated('folder_id', 1),
                'episode' => $request->validated('episode'),
            ]);

        return response()->json([
            'favorite' => [
                'folder_id' => $favorite->anime_folder_id,
                'episode' => $favorite->episode,
            ],
            'message' => Lang::get('reina.anime.favorite_change_episode'),
        ]);
    }
}
