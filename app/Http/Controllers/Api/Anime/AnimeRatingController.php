<?php

namespace App\Http\Controllers\Api\Anime;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\RatingAnimeRequest;
use App\Http\Resources\RatingResource;
use App\Models\Anime;
use App\Models\AnimeRating;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;

class AnimeRatingController extends Controller
{
    public function show($slug): RatingResource|JsonResponse
    {
        $ratingUser = AnimeRating::query()
            ->where('user_id', auth()->id())
            ->where('anime_id', getIdFromSlug($slug))
            ->first();

        if (! $ratingUser) {
            return response()->json(['data' => null]);
        }

        return RatingResource::make($ratingUser);
    }

    public function store(RatingAnimeRequest $request): RatingResource
    {
        $anime = Anime::query()
            ->select(['id', 'slug', 'is_rating'])
            ->findOrFail($request->validated('id'));

        Gate::authorize('isRating', $anime);

        $ratingUser = AnimeRating::query()->updateOrCreate([
            'user_id' => auth()->id(),
            'anime_id' => $anime->id,
        ], [
            'assessment' => $request->validated('assessment'),
        ]);

        return RatingResource::make($ratingUser);
    }

    public function destroy($slug): JsonResponse
    {
        $anime = Anime::query()
            ->select(['id', 'slug'])
            ->findOrFail(getIdFromSlug($slug));

        $anime->ratings()
            ->where('user_id', auth()->id())
            ->delete();

        return response()->json(Lang::get('reina.anime.rating_destroy'));
    }
}
