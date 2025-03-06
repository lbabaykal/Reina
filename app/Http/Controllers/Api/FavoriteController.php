<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FavoriteResource;
use Illuminate\Http\JsonResponse;

class FavoriteController extends Controller
{
    public function index(): JsonResponse
    {
        $foldersAnimes = auth()->user()
            ->favoriteAnimes()
            ->select(['slug', 'poster', 'title_ru', 'rating', 'episodes_released', 'episodes_total', 'is_rating', 'favorite_animes.updated_at'])
            ->latest('favorite_animes.updated_at')
            ->limit(8)
            ->get();

        $foldersDoramas = auth()->user()
            ->favoriteDoramas()
            ->select(['slug', 'poster', 'title_ru', 'rating', 'episodes_released', 'episodes_total', 'is_rating', 'favorite_doramas.updated_at'])
            ->latest('favorite_doramas.updated_at')
            ->limit(8)
            ->get();

        return response()->json([
            'animes' => FavoriteResource::collection($foldersAnimes),
            'doramas' => FavoriteResource::collection($foldersDoramas),
        ]);
    }
}
