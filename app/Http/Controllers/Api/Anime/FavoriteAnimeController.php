<?php

namespace App\Http\Controllers\Api\Anime;

use App\Http\Controllers\Controller;
use App\Http\Requests\Favorite\FavoriteAnimesEpisodeRequest;
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

    public function store(FavoriteAnimesRequest $request, int $id): JsonResponse
    {
        $anime = Anime::query()->select(['id', 'slug'])->findOrFail($id);

        $favorite = FavoriteAnime::query()
            ->updateOrCreate([
                'user_id' => auth()->id(),
                'anime_id' => $anime->id,
            ], [
                'anime_folder_id' => $request->validated('folder_id'),
                'anime_episode_id' => null,
            ]);

        return response()->json([
            'favorite' => [
                'folder_id' => $favorite->anime_folder_id,
                'episode_id' => $favorite->anime_episode_id ?? 0,
            ],
            'message' => Lang::get('reina.anime.favorite_store'),
        ]);
    }

    public function update(FavoriteAnimesRequest $request, int $id): JsonResponse
    {
        $anime = Anime::query()->select(['id', 'slug'])->findOrFail($id);

        $anime->favorites()
            ->where('user_id', auth()->id())
            ->update(['anime_folder_id' => $request->validated('folder_id')]);

        $favorite = $anime->favorites()
            ->select('anime_folder_id', 'anime_episode_id')
            ->where('user_id', auth()->id())
            ->first();

        return response()->json([
            'favorite' => [
                'folder_id' => $favorite->anime_folder_id,
                'episode_id' => $favorite->anime_episode_id ?? 0,
            ],
            'message' => Lang::get('reina.anime.favorite_update'),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $anime = Anime::query()->select(['id', 'slug'])->findOrFail($id);

        $anime->favorites()
            ->where('user_id', auth()->id())
            ->delete();

        return response()->json(Lang::get('reina.anime.favorite_destroy'));
    }

    public function rememberEpisode(FavoriteAnimesEpisodeRequest $request, int $id): JsonResponse
    {
        $anime = Anime::query()->select(['id', 'slug'])->findOrFail($id);

        $favorite = $anime->favorites()
            ->updateOrCreate([
                'user_id' => auth()->id(),
            ], [
                'anime_folder_id' => $request->validated('folder_id') ?? 1,
                'anime_episode_id' => $request->validated('episode_id'),
            ]);

        return response()->json([
            'favorite' => [
                'folder_id' => $favorite->anime_folder_id,
                'episode_id' => $favorite->anime_episode_id,
            ],
            'message' => Lang::get('reina.anime.favorite_remember_episode'),
        ]);
    }

    public function forgetEpisode(int $id): JsonResponse
    {
        $anime = Anime::query()->select(['id', 'slug'])->findOrFail($id);

        $anime->favorites()
            ->where('user_id', auth()->id())
            ->update(['anime_episode_id' => null]);

        return response()->json(Lang::get('reina.anime.favorite_forget_episode'));
    }
}
