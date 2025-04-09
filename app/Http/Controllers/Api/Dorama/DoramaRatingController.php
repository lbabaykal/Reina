<?php

namespace App\Http\Controllers\Api\Dorama;

use App\Http\Controllers\Controller;
use App\Http\Requests\RatingRequest;
use App\Models\Dorama;
use App\Models\DoramaRating;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;

class DoramaRatingController extends Controller
{
    public function store(RatingRequest $request, $doramaId): JsonResponse
    {
        $dorama = Dorama::query()
            ->select(['id', 'slug', 'is_rating'])
            ->where('id', $doramaId)
            ->firstOrFail();

        Gate::authorize('isRating', $dorama);

        $doramaRating = new DoramaRating([
            'user_id' => auth()->id(),
            'assessment' => $request->validated('assessment'),
        ]);

        $dorama->ratings()->save($doramaRating);

        return response()->json(Lang::get('reina.dorama.rating_store'));
    }

    public function update(RatingRequest $request, $doramaId): JsonResponse
    {
        $dorama = Dorama::query()
            ->select(['id', 'slug', 'is_rating'])
            ->where('id', $doramaId)
            ->firstOrFail();

        Gate::authorize('isRating', $dorama);

        $dorama->ratings()
            ->where('user_id', auth()->id())
            ->update(['assessment' => $request->validated('assessment')]);

        return response()->json(Lang::get('reina.dorama.rating_update'));
    }

    public function destroy($doramaId): JsonResponse
    {
        $dorama = Dorama::query()
            ->select(['id', 'slug'])
            ->where('id', $doramaId)
            ->firstOrFail();

        $dorama->ratings()
            ->where('user_id', auth()->id())
            ->delete();

        return response()->json(Lang::get('reina.dorama.rating_destroy'));
    }
}
