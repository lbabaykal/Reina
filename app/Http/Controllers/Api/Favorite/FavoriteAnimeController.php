<?php

namespace App\Http\Controllers\Api\Favorite;

use App\Http\Controllers\Controller;
use App\Http\Requests\Favorite\FavoriteAnimesRequest;
use App\Models\Anime;
use App\Models\AnimeFolder;
use App\Models\FavoriteAnime;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Lang;

class FavoriteAnimeController extends Controller
{
    public function show(): JsonResponse
    {
        $foldersUser = AnimeFolder::query()
            ->select(['id', 'title'])
            ->where('user_id', auth()->id())
            ->orWhere('user_id', 0)
            ->orderBy('id')
            ->get();

        return response()->json([
            'folders' => $foldersUser,
        ]);
    }

    public function store(FavoriteAnimesRequest $request, $animeId): JsonResponse
    {
        $anime = Anime::query()
            ->select(['id', 'slug'])
            ->where('id', $animeId)
            ->firstOrFail();

        $favoriteAnime = new FavoriteAnime([
            'user_id' => auth()->id(),
            'anime_id' => $anime->id,
            'anime_folder_id' => $request->validated('folder_id'),
            'episode' => 0,
        ]);

        $favoriteAnime->save();

        return response()->json(Lang::get('reina.anime.favorite_store'));
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

        return response()->json(Lang::get('reina.anime.favorite_update'));
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

        return response()->json(Lang::get('reina.anime.favorite_destroy'));
    }
}
