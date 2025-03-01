<?php

namespace App\Http\Controllers\Api;

use App\Enums\CacheEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Main\MainAnimesResource;
use App\Http\Resources\Main\MainDoramasResource;
use App\Models\Anime;
use App\Models\Dorama;
use App\Reina;
use Illuminate\Http\JsonResponse;

class MainController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $animes = cache()->store('redis_animes')->flexible(CacheEnum::MAIN_ANIMES->value, [1200, 1800], function () {
            return Anime::query()
                ->select(['id', 'slug', 'poster', 'title_ru', 'rating', 'episodes_released', 'episodes_total', 'is_rating'])
                ->limit(Reina::COUNT_ARTICLES_MAIN)
                ->latest('updated_at')
                ->get();
        });

        $doramas = cache()->store('redis_doramas')->flexible(CacheEnum::MAIN_DORAMAS->value, [1200, 1800], function () {
            return Dorama::query()
                ->select(['id', 'slug', 'poster', 'title_ru', 'rating', 'episodes_released', 'episodes_total', 'is_rating'])
                ->limit(Reina::COUNT_ARTICLES_MAIN)
                ->latest('updated_at')
                ->get();
        });

        return response()->json([
            'animes' => MainAnimesResource::collection($animes),
            'doramas' => MainDoramasResource::collection($doramas),
        ]);
    }
}
