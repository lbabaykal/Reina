<?php

namespace App\Http\Controllers\Api\Rating;

use App\Http\Controllers\Controller;
use App\Http\Requests\RatingRequest;
use App\Models\Anime;
use App\Models\AnimeRating;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;

class AnimeRatingController extends Controller
{
    public function store(RatingRequest $request, $animeId): JsonResponse
    {
        $anime = Anime::query()
            ->select(['id', 'slug', 'is_rating'])
            ->where('id', $animeId)
            ->firstOrFail();

        Gate::authorize('isRating', $anime);

        $animeRating = new AnimeRating([
            'user_id' => auth()->id(),
            'assessment' => $request->validated('assessment'),
        ]);

        $anime->ratings()->save($animeRating);

        return response()->json(Lang::get('reina.anime.rating_store'));
    }

    public function update(RatingRequest $request, $animeId): JsonResponse
    {
        $anime = Anime::query()
            ->select(['id', 'slug', 'is_rating'])
            ->where('id', $animeId)
            ->firstOrFail();

        Gate::authorize('isRating', $anime);

        $anime->ratings()
            ->where('user_id', auth()->id())
            ->update(['assessment' => $request->validated('assessment')]);

        return response()->json(Lang::get('reina.anime.rating_update'));
    }

    public function destroy($animeId): JsonResponse
    {
        $anime = Anime::query()
            ->select(['id', 'slug'])
            ->where('id', $animeId)
            ->firstOrFail();

        $anime->ratings()
            ->where('user_id', auth()->id())
            ->delete();

        return response()->json(Lang::get('reina.anime.rating_destroy'));
    }
}
