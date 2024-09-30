<?php

use App\Models\Anime;
use App\Models\Dorama;
use App\Reina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return new \App\Http\Resources\UserLoginResource(auth()->user());
})->middleware('auth:sanctum');

Route::domain('reina.online')
    ->get('/main', function () {
        $animes = cache()->store('redis_animes')->rememberForever('main_animes', function () {
            return Anime::query()
                ->select(['id', 'slug', 'poster', 'title_ru', 'rating', 'episodes_released', 'episodes_total'])
                ->limit(Reina::COUNT_ARTICLES_MAIN)
                ->latest('updated_at')
                ->get();
        });

        $doramas = cache()->store('redis_doramas')->rememberForever('main_doramas', function () {
            return Dorama::query()
                ->select(['id', 'slug', 'poster', 'title_ru', 'rating', 'episodes_released', 'episodes_total'])
                ->limit(Reina::COUNT_ARTICLES_MAIN)
                ->latest('updated_at')
                ->get();
        });
        return response([
            'animes' => \App\Http\Resources\MainAnimesResource::collection($animes),
            'doramas' => \App\Http\Resources\MainDoramasResource::collection($doramas),
        ]);
    });
