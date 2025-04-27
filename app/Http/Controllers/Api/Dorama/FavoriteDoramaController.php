<?php

namespace App\Http\Controllers\Api\Dorama;

use App\Http\Controllers\Controller;
use App\Http\Requests\Favorite\FavoriteDoramasRequest;
use App\Http\Resources\Favorite\FavoriteDoramaResource;
use App\Models\FavoriteDorama;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Lang;

class FavoriteDoramaController extends Controller
{
    public function show($slug): JsonResponse|FavoriteDoramaResource
    {
        $favoriteDorama = FavoriteDorama::query()
            ->where('dorama_id', getIdFromSlug($slug))
            ->where('user_id', auth()->id())
            ->first();

        if (! $favoriteDorama) {
            return response()->json(['data' => null]);
        }

        return FavoriteDoramaResource::make($favoriteDorama);
    }

    public function store(FavoriteDoramasRequest $request): FavoriteDoramaResource
    {
        $data = $request->validated();

        $favorite = FavoriteDorama::query()
            ->firstOrCreate([
                'user_id' => auth()->id(),
                'dorama_id' => $data['id'],
            ], [
                'dorama_folder_id' => $data['folder_id'] ?? 1,
            ]);

        $updateData = [];

        if (isset($data['folder_id'])) {
            $updateData['dorama_folder_id'] = $data['folder_id'];
        }

        if (isset($data['episode_id'])) {
            $updateData['dorama_episode_id'] = $data['episode_id'];
        }

        $favorite->update($updateData);

        return FavoriteDoramaResource::make($favorite);
    }

    public function destroy($id): JsonResponse
    {
        $favoriteAnime = FavoriteDorama::query()
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->delete();

        if (! $favoriteAnime) {
            return response()->json(Lang::get('reina.dorama.favorite_destroy_error'));
        }

        return response()->json(Lang::get('reina.dorama.favorite_destroy'));
    }
}
