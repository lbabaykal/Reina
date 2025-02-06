<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FavoriteAnimesRequest;
use App\Http\Requests\FavoriteDoramasRequest;
use App\Models\Anime;
use App\Models\Dorama;
use App\Models\FolderAnime;
use App\Models\FolderDorama;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class FavoriteController extends Controller
{
    /* ================ Anime ================ */
    public function getForAnime(): Response
    {
        $foldersUser = FolderAnime::query()
            ->select(['id', 'title'])
            ->where('user_id', auth()->id())
            ->orWhere('user_id', 0)
            ->orderBy('id')
            ->get();

        return response([
            'folders' => $foldersUser,
        ]);
    }
    public function addForAnime(FavoriteAnimesRequest $request, $id): Response
    {
        if (!auth()->check()) {
            abort(401);
        }

        $anime = Anime::query()
            ->select(['id', 'slug'])
            ->where('id', $id)
            ->firstOrFail();

        $anime->favorites()->updateOrCreate(
            ['user_id' => auth()->id()],
            ['folder_anime_id' => $request->validated('folder')]
        );

        return response()->noContent();
    }

    public function removeForAnime($id): Response
    {
        if (!auth()->check()) {
            abort(401);
        }

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
    public function getForDorama(): Response
    {
        $foldersUser = FolderDorama::query()
            ->select(['id', 'title'])
            ->where('user_id', auth()->id())
            ->orWhere('user_id', 0)
            ->orderBy('id')
            ->get();

        return response([
            'folders' => $foldersUser,
        ]);
    }

    public function addForDorama(FavoriteDoramasRequest $request, $id): RedirectResponse
    {
        if (!auth()->check()) {
            abort(401);
        }

        $dorama = Dorama::query()
            ->select(['id', 'slug'])
            ->where('id', $id)
            ->firstOrFail();

        $dorama->favorites()->updateOrCreate(
            ['user_id' => auth()->id()],
            ['folder_dorama_id' => $request->validated('folder')]
        );

        return redirect()->back();
    }

    public function removeForDorama($id): RedirectResponse
    {
        if (!auth()->check()) {
            abort(401);
        }

        $dorama = Dorama::query()
            ->select(['id', 'slug'])
            ->where('id', $id)
            ->firstOrFail();

        $dorama->favorites()
            ->where('user_id', auth()->id())
            ->delete();

        return redirect()->back();
    }
}
