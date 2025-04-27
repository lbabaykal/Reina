<?php

namespace App\Http\Controllers\Api\Dorama;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rating\RatingDoramaRequest;
use App\Http\Resources\RatingResource;
use App\Models\Dorama;
use App\Models\DoramaRating;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;

class DoramaRatingController extends Controller
{
    public function show($slug): RatingResource|JsonResponse
    {
        $ratingUser = DoramaRating::query()
            ->where('user_id', auth()->id())
            ->where('dorama_id', getIdFromSlug($slug))
            ->first();

        if (! $ratingUser) {
            return response()->json(['data' => null]);
        }

        return RatingResource::make($ratingUser);
    }

    public function store(RatingDoramaRequest $request): RatingResource
    {
        $dorama = Dorama::query()
            ->select(['id', 'slug', 'is_rating'])
            ->findOrFail($request->validated('id'));

        Gate::authorize('isRating', $dorama);

        $ratingUser = DoramaRating::query()->updateOrCreate([
            'user_id' => auth()->id(),
            'dorama_id' => $dorama->id,
        ], [
            'assessment' => $request->validated('assessment'),
        ]);

        return RatingResource::make($ratingUser);
    }

    public function destroy($slug): JsonResponse
    {
        $dorama = Dorama::query()
            ->select(['id', 'slug'])
            ->findOrFail(getIdFromSlug($slug));

        $dorama->ratings()
            ->where('user_id', auth()->id())
            ->delete();

        return response()->json(Lang::get('reina.dorama.rating_destroy'));
    }
}
