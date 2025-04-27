<?php

namespace App\Http\Controllers\Api\Anime;

use App\Http\Controllers\Controller;
use App\Http\Requests\Favorite\FavoriteAnimeRequest;
use App\Http\Resources\Favorite\FavoriteAnimeResource;
use App\Models\FavoriteAnime;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Lang;

class FavoriteAnimeController extends Controller
{
    public function show($slug): JsonResponse|FavoriteAnimeResource
    {
        $favoriteAnime = FavoriteAnime::query()
            ->where('anime_id', getIdFromSlug($slug))
            ->where('user_id', auth()->id())
            ->first();

        if (! $favoriteAnime) {
            return response()->json(['data' => null]);
        }

        return FavoriteAnimeResource::make($favoriteAnime);
    }

    public function store(FavoriteAnimeRequest $request): FavoriteAnimeResource
    {
        $data = $request->validated();

        $favorite = FavoriteAnime::query()
            ->firstOrCreate([
                'user_id' => auth()->id(),
                'anime_id' => $data['id'],
            ], [
                'anime_folder_id' => $data['folder_id'] ?? 1,
            ]);

        $updateData = [];

        if (isset($data['folder_id'])) {
            $updateData['anime_folder_id'] = $data['folder_id'];
        }

        if (isset($data['episode_id'])) {
            $updateData['anime_episode_id'] = $data['episode_id'];
        }

        $favorite->update($updateData);

        return FavoriteAnimeResource::make($favorite);
    }

    public function destroy($id): JsonResponse
    {
        $favoriteAnime = FavoriteAnime::query()
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->delete();

        if (! $favoriteAnime) {
            return response()->json(Lang::get('reina.anime.favorite_destroy_error'));
        }

        return response()->json(Lang::get('reina.anime.favorite_destroy'));
    }
}
