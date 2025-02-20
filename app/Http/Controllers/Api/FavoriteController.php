<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Favorite\FavoriteAnimesRequest;
use App\Http\Requests\Favorite\FavoriteDoramasRequest;
use App\Http\Resources\Favorites\FavoriteAnimesResource;
use App\Http\Resources\Favorites\FavoriteDoramasResource;
use App\Models\Anime;
use App\Models\Dorama;
use App\Models\AnimeFolder;
use App\Models\DoramaFolder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FavoriteController extends Controller
{
    private function checkAuth(): void
    {
        if (!auth()->check()) {
            abort(401);
        }
    }

    public function index(): JsonResponse
    {
        $this->checkAuth();

        $foldersAnimes = auth()->user()
            ->favoriteAnimes()
            ->select(['slug', 'poster', 'title_ru', 'rating', 'episodes_released', 'episodes_total', 'favorite_animes.updated_at'])
            ->latest('favorite_animes.updated_at')
            ->limit(8)
            ->get();

        $foldersDoramas = auth()->user()
            ->favoriteDoramas()
            ->select(['slug', 'poster', 'title_ru', 'rating', 'episodes_released', 'episodes_total', 'favorite_doramas.updated_at'])
            ->latest('favorite_doramas.updated_at')
            ->limit(8)
            ->get();

        return response()->json([
            'animes' => FavoriteAnimesResource::collection($foldersAnimes),
            'doramas' => FavoriteDoramasResource::collection($foldersDoramas),
        ]);
    }

    /* ================ Anime ================ */
    public function getForAnime(): JsonResponse
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
    public function addForAnime(FavoriteAnimesRequest $request, $id): Response
    {
        $this->checkAuth();

        $anime = Anime::query()
            ->select(['id', 'slug'])
            ->where('id', $id)
            ->firstOrFail();

        $anime->favorites()->updateOrCreate(
            ['user_id' => auth()->id()],
            ['anime_folder_id' => $request->validated('folder')]
        );

        return response()->noContent();
    }

    public function removeForAnime($id): Response
    {
        $this->checkAuth();

        $anime = Anime::query()
            ->select(['id', 'slug'])
            ->where('id', $id)
            ->firstOrFail();

        $anime->favorites()
            ->where('user_id', auth()->id())
            ->delete();

        return response()->noContent();
    }

    /* ================ Dorama ================ */
    public function getForDorama(): JsonResponse
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

    public function addForDorama(FavoriteDoramasRequest $request, $id): Response
    {
        $this->checkAuth();

        $dorama = Dorama::query()
            ->select(['id', 'slug'])
            ->where('id', $id)
            ->firstOrFail();

        $dorama->favorites()->updateOrCreate(
            ['user_id' => auth()->id()],
            ['dorama_folder_id' => $request->validated('folder')]
        );

        return response()->noContent();
    }

    public function removeForDorama($id): Response
    {
        $this->checkAuth();

        $dorama = Dorama::query()
            ->select(['id', 'slug'])
            ->where('id', $id)
            ->firstOrFail();

        $dorama->favorites()
            ->where('user_id', auth()->id())
            ->delete();

        return response()->noContent();
    }
}
